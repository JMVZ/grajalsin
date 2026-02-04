<?php

namespace App\Console\Commands;

use App\Models\Bodega;
use App\Models\Chofer;
use App\Models\Cliente;
use App\Models\Destino;
use App\Models\Producto;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportarExcelCommand extends Command
{
    protected $signature = 'importar:excel 
                            {--bodegas= : Ruta al archivo RELACION DE BODEGAS.xlsx}
                            {--choferes= : Ruta al archivo RELACION DE CHOFERES.xlsx}
                            {--productos= : Ruta al archivo RELACION DE PRODUCTOS.xlsx}
                            {--destinos= : Ruta al archivo RELACION DESTINOS.xlsx}
                            {--clientes= : Ruta al archivo RELACION CLIENTES}
                            {--carpeta= : Carpeta con todos los archivos (ej: /Users/jm/Downloads)}';

    protected $description = 'Importa datos desde archivos Excel (bodegas, choferes, productos, destinos, clientes)';

    public function handle(): int
    {
        $carpeta = $this->option('carpeta');
        $archivos = [
            'bodegas' => $this->option('bodegas') ?? ($carpeta ? $carpeta . '/RELACION DE BODEGAS.xlsx' : null),
            'choferes' => $this->option('choferes') ?? ($carpeta ? $carpeta . '/RELACION DE CHOFERES.xlsx' : null),
            'productos' => $this->option('productos') ?? ($carpeta ? $carpeta . '/RELACION DE PRODUCTOS.xlsx' : null),
            'destinos' => $this->option('destinos') ?? ($carpeta ? $carpeta . '/RELACION DESTINOS.xlsx' : null),
            'clientes' => $this->option('clientes') ?? ($carpeta ? $carpeta . '/RELACION CLIENTES 2026.xlsx' : null),
        ];

        $importados = 0;

        foreach ($archivos as $tipo => $ruta) {
            if (!$ruta || !file_exists($ruta)) {
                $this->warn("Archivo no encontrado o no especificado: {$tipo}");
                continue;
            }

            try {
                $count = match ($tipo) {
                    'bodegas' => $this->importarBodegas($ruta),
                    'choferes' => $this->importarChoferes($ruta),
                    'productos' => $this->importarProductos($ruta),
                    'destinos' => $this->importarDestinos($ruta),
                    'clientes' => $this->importarClientes($ruta),
                };
                $this->info("✅ {$tipo}: {$count} registros importados");
                $importados += $count;
            } catch (\Throwable $e) {
                $this->error("❌ Error en {$tipo}: " . $e->getMessage());
            }
        }

        $this->info("\n📊 Total: {$importados} registros importados");
        return Command::SUCCESS;
    }

    private function importarBodegas(string $ruta): int
    {
        $data = $this->leerExcel($ruta);
        $ultimoNombre = '';
        $count = 0;

        foreach ($data as $fila) {
            // Forward-fill: si NOMBRE BODEGA está vacío, usar el de la fila anterior
            $nombre = trim($fila['NOMBRE BODEGA'] ?? $fila['nombre'] ?? '');
            if (!empty($nombre)) {
                $ultimoNombre = $nombre;
            }
            $nombre = $ultimoNombre ?: $nombre;
            if (empty($nombre)) continue;

            $ubicacion = trim($fila['UBICACIÓN'] ?? $fila['ubicacion'] ?? '');
            $clave = trim($fila['CLAVE'] ?? $fila['clave'] ?? '');
            if (empty($clave)) continue;

            // Usar clave como identificador único (cada ubicación tiene B-001, B-002, etc.)
            Bodega::updateOrCreate(
                ['clave' => $clave],
                [
                    'nombre' => $nombre,
                    'ubicacion' => $ubicacion,
                    'estatus' => true,
                ]
            );
            $count++;
        }
        return $count;
    }

    private function importarChoferes(string $ruta): int
    {
        $data = $this->leerExcel($ruta);
        $count = 0;
        foreach ($data as $fila) {
            $nombre = trim($fila['NOMBRE:'] ?? $fila['NOMBRE'] ?? $fila['nombre'] ?? '');
            if (empty($nombre)) continue;

            $curp = trim($fila['CURP O RFC'] ?? $fila['curp'] ?? '');
            $telefono = $this->limpiarTelefono($fila['TELEFONO'] ?? $fila['telefono'] ?? '');
            $licencia = trim($fila['LICENCIA'] ?? $fila['licencia_numero'] ?? '');

            Chofer::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'telefono' => $telefono ?: null,
                    'curp' => $curp ?: null,
                    'licencia_numero' => $licencia ?: null,
                    'estatus' => true,
                ]
            );
            $count++;
        }
        return $count;
    }

    private function importarProductos(string $ruta): int
    {
        $data = $this->leerExcel($ruta);
        $count = 0;
        foreach ($data as $fila) {
            $nombre = trim($fila['PRODUCTO'] ?? $fila['nombre'] ?? '');
            if (empty($nombre)) continue;

            $unidad = trim($fila['UNDAD'] ?? $fila['unidad_medida'] ?? 'kg');
            $codigo = $fila['CODIGO'] ?? $fila['codigo'] ?? null;
            if (is_numeric($codigo)) {
                $codigo = (string) $codigo;
            }
            $codigo = $codigo ? trim((string) $codigo) : null;

            Producto::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'codigo' => $codigo,
                    'unidad_medida' => $this->normalizarUnidad($unidad),
                    'activo' => true,
                ]
            );
            $count++;
        }
        return $count;
    }

    private function importarClientes(string $ruta): int
    {
        $data = $this->leerExcel($ruta, 0);
        $ultimoNombre = '';
        $count = 0;

        foreach ($data as $fila) {
            $codigo = trim($fila['CODIGO'] ?? $fila['codigo'] ?? '');
            if (empty($codigo)) continue;

            // Forward-fill: si NOMBRE está vacío, usar CONTACTO o el de la fila anterior
            $nombre = trim($fila['NOMBRE O RAZON SOCIAL'] ?? $fila['nombre'] ?? '');
            $contacto = trim($fila['CONTACTO'] ?? $fila['contacto'] ?? '');
            if (!empty($nombre)) {
                $ultimoNombre = $nombre;
            }
            $nombre = $nombre ?: ($contacto ?: $ultimoNombre);
            if (empty($nombre)) continue;

            $celular = trim($fila['CELULAR'] ?? '') ?: null;
            $telefono = trim($fila['TELEFONO'] ?? '') ?: null;

            $rfc = trim($fila['RFC'] ?? $fila['rfc'] ?? '') ?: null;
            $email = trim($fila['EMAIL'] ?? $fila['email'] ?? '') ?: null;
            $formaPago = trim($fila['FORMA DE PAGO'] ?? '') ?: null;

            $notas = $formaPago ? "Forma de pago: {$formaPago}" : null;

            Cliente::updateOrCreate(
                ['codigo' => $codigo],
                [
                    'nombre' => $nombre,
                    'rfc' => $rfc,
                    'contacto' => $contacto ?: null,
                    'celular' => $celular,
                    'telefono' => $telefono,
                    'email' => $email,
                    'estatus' => true,
                    'notas' => $notas,
                ]
            );
            $count++;
        }
        return $count;
    }

    private function importarDestinos(string $ruta): int
    {
        $data = $this->leerExcel($ruta);
        $count = 0;
        foreach ($data as $fila) {
            $nombre = trim($fila['DESTINO'] ?? $fila['nombre'] ?? '');
            if (empty($nombre)) continue;

            Destino::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'estado' => trim($fila['ESTADO'] ?? $fila['estado'] ?? ''),
                    'estatus' => true,
                ]
            );
            $count++;
        }
        return $count;
    }

    private function leerExcel(string $ruta, ?int $sheetIndex = null): array
    {
        $spreadsheet = IOFactory::load($ruta);
        $sheet = $sheetIndex !== null ? $spreadsheet->getSheet($sheetIndex) : $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        if (empty($rows)) return [];

        $headers = array_map('trim', $rows[0]);
        $data = [];
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $fila = [];
            foreach ($headers as $j => $header) {
                if ($header !== '') {
                    $fila[$header] = $row[$j] ?? '';
                }
            }
            $data[] = $fila;
        }
        return $data;
    }

    private function limpiarTelefono(string $tel): string
    {
        $tel = preg_replace('/[^0-9]/', '', $tel);
        return $tel ?: '';
    }

    private function normalizarUnidad(string $u): string
    {
        $u = strtolower(trim($u));
        if (in_array($u, ['kgs', 'kg', 'kilogramos'])) return 'kg';
        if (in_array($u, ['ton', 'toneladas', 'tonelada'])) return 'toneladas';
        if (in_array($u, ['costales', 'costal'])) return 'costales';
        if (in_array($u, ['quintales', 'quintal'])) return 'quintales';
        if (in_array($u, ['pieza', 'piezas'])) return 'pieza';
        return $u ?: 'kg';
    }
}
