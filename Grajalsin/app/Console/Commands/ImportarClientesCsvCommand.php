<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use App\Models\MovimientoCuentaCliente;
use App\Models\PagoCliente;
use App\Models\PedidoVenta;
use App\Models\PreOrden;
use App\Models\ServicioLogistica;
use Illuminate\Console\Command;

class ImportarClientesCsvCommand extends Command
{
    protected $signature = 'importar:clientes-csv 
                            {archivo? : Ruta al CSV (ej: RELACION CLIENTES 2026.csv)}';

    protected $description = 'Borra todos los clientes (y datos que dependen de ellos), luego importa solo los 86 del CSV en ese orden.';

    public function handle(): int
    {
        $archivo = $this->argument('archivo');

        if (!$archivo || !is_file($archivo)) {
            $this->error('Indica la ruta al CSV.');
            $this->line('Ejemplo: php artisan importar:clientes-csv "/Users/jm/Downloads/RELACION CLIENTES 2026.csv"');
            return Command::FAILURE;
        }

        // 1. Leer todo el CSV y guardar filas en orden
        $filas = $this->leerCsv($archivo);
        if (empty($filas)) {
            $this->error('No se encontraron filas válidas en el CSV (código G-001, G-002, etc.).');
            return Command::FAILURE;
        }

        // 2. Borrar en orden por dependencias (para poder borrar clientes)
        $this->info('Borrando datos que usan clientes...');
        MovimientoCuentaCliente::query()->delete();
        PagoCliente::query()->delete();
        PedidoVenta::query()->delete();
        ServicioLogistica::query()->delete();
        PreOrden::query()->delete();
        $n = Cliente::query()->count();
        Cliente::query()->delete();
        $this->info("Borrados todos los clientes ({$n}).");

        // 3. Insertar los 86 del CSV en el mismo orden
        foreach ($filas as $fila) {
            Cliente::create([
                'codigo' => $fila['codigo'],
                'nombre' => $fila['nombre'],
                'rfc' => $fila['rfc'],
                'contacto' => $fila['contacto'],
                'celular' => $fila['celular'],
                'telefono' => $fila['telefono'],
                'email' => $fila['email'],
                'estatus' => true,
            ]);
        }

        $this->info('✅ Importados ' . count($filas) . ' clientes del CSV en ese orden (G-001 … G-086).');
        return Command::SUCCESS;
    }

    /** @return array<int, array{codigo: string, nombre: string, rfc: ?string, contacto: ?string, celular: ?string, telefono: ?string, email: ?string}> */
    private function leerCsv(string $archivo): array
    {
        $handle = fopen($archivo, 'r');
        if ($handle === false) {
            return [];
        }
        rewind($handle);
        fgetcsv($handle, 0, ','); // cabecera
        $filas = [];
        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $codigo = isset($row[2]) ? trim((string) $row[2]) : '';
            if ($codigo === '' || !preg_match('/^G-\d+/i', $codigo)) {
                continue;
            }
            $nombre = isset($row[1]) ? trim((string) $row[1]) : '';
            if ($nombre === '') {
                continue;
            }
            $filas[] = [
                'codigo' => mb_strtoupper($codigo),
                'nombre' => $nombre,
                'rfc' => isset($row[3]) && trim((string) $row[3]) !== '' ? trim((string) $row[3]) : null,
                'contacto' => isset($row[4]) && trim((string) $row[4]) !== '' ? trim((string) $row[4]) : null,
                'celular' => isset($row[5]) && trim((string) $row[5]) !== '' ? trim((string) $row[5]) : null,
                'telefono' => isset($row[6]) && trim((string) $row[6]) !== '' ? trim((string) $row[6]) : null,
                'email' => isset($row[7]) && trim((string) $row[7]) !== '' ? trim((string) $row[7]) : null,
            ];
        }
        fclose($handle);
        return $filas;
    }
}
