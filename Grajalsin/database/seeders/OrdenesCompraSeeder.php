<?php

namespace Database\Seeders;

use App\Models\OrdenCompra;
use App\Models\OrdenCompraLinea;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrdenesCompraSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $usuarios = User::all();

        if ($proveedores->isEmpty()) {
            $this->command->warn('No hay proveedores. Creando 10 de prueba...');
            $nombres = ['Sacos Sasin', 'Granos del Norte', 'Insumos Agrícolas SA', 'Costalera Nacional', 'Proveedor Express', 'Almacenes del Campo', 'Comercializadora de Granos', 'Distribuidora de Insumos', 'Agroinsumos México', 'Bodega Central'];
            foreach ($nombres as $nombre) {
                Proveedor::create([
                    'nombre' => $nombre,
                    'rfc' => 'XAXX010101000',
                    'contacto' => 'Contacto ' . $nombre,
                    'telefono' => '55' . rand(10000000, 99999999),
                    'estatus' => true,
                ]);
            }
            $proveedores = Proveedor::all();
        }

        if ($productos->isEmpty()) {
            $this->command->warn('No hay productos. Usando descripciones genéricas.');
        }

        $usosCfdi = array_keys(config('cfdi.usos_cfdi', []));
        $formasPago = ['Transferencia PPD', 'Efectivo', 'Cheque', 'Tarjeta crédito', 'Crédito 30 días'];
        $articulosInsumos = [
            'Costal polipropileno 50x75 cm',
            'Costal polipropileno 60x90 cm',
            'Paca 500 costales',
            'Cinta de seguridad',
            'Etiquetas impresas',
        ];
        $articulosGranos = [
            'Maíz blanco',
            'Maíz amarillo',
            'Trigo',
            'Sorgo',
            'Frijol',
        ];
        $elaboradores = ['Karina Heraldez', 'Maria Arce', 'Juan Pérez', 'Ana López', 'Carlos Ruiz'];

        $ultimoInsumos = OrdenCompra::where('folio', 'like', 'OCI-%')->orderByDesc('id')->value('folio');
        $ultimoGranos = OrdenCompra::where('folio', 'like', 'OCG-%')->orderByDesc('id')->value('folio');
        $contadorInsumos = $ultimoInsumos && preg_match('/OCI-(\d+)/', $ultimoInsumos, $m) ? (int) $m[1] : 0;
        $contadorGranos = $ultimoGranos && preg_match('/OCG-(\d+)/', $ultimoGranos, $m) ? (int) $m[1] : 0;

        $user = $usuarios->first();

        for ($i = 0; $i < 100; $i++) {
            $tipo = $i % 2 === 0 ? 'insumos' : 'granos';
            $contadorInsumos += ($tipo === 'insumos' ? 1 : 0);
            $contadorGranos += ($tipo === 'granos' ? 1 : 0);
            $prefijo = $tipo === 'granos' ? 'OCG' : 'OCI';
            $num = $tipo === 'granos' ? $contadorGranos : $contadorInsumos;
            $folio = $prefijo . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);

            $fecha = now()->subDays(rand(1, 365));
            // Solo estados activa o cancelada (90% activa, 10% cancelada)
            $estatus = rand(1, 10) <= 9 ? 'activa' : 'cancelada';

            $orden = OrdenCompra::create([
                'tipo' => $tipo,
                'folio' => $folio,
                'fecha' => $fecha,
                'proveedor_id' => $proveedores->random()->id,
                'forma_pago' => $formasPago[array_rand($formasPago)],
                'uso_cfdi' => $usosCfdi[array_rand($usosCfdi)] ?? 'G03',
                'elaborado_por' => $elaboradores[array_rand($elaboradores)],
                'solicitado_por' => $elaboradores[array_rand($elaboradores)],
                'estatus' => $estatus,
                'user_id' => $user?->id,
            ]);

            $articulos = $tipo === 'insumos' ? $articulosInsumos : $articulosGranos;
            $numLineas = rand(1, 4);
            $subtotal = 0;

            for ($j = 0; $j < $numLineas; $j++) {
                $cantidad = rand(10, 500) * (rand(1, 10) / 10);
                $precio = rand(1, 50) * (rand(1, 100) / 100);
                $importe = round($cantidad * $precio, 2);
                $subtotal += $importe;

                $producto = $productos->isNotEmpty() ? $productos->random() : null;

                OrdenCompraLinea::create([
                    'orden_compra_id' => $orden->id,
                    'producto_id' => $producto?->id,
                    'descripcion' => $articulos[array_rand($articulos)],
                    'cantidad' => $cantidad,
                    'unidad' => $tipo === 'insumos' ? 'paca' : 'kg',
                    'piezas' => $tipo === 'insumos' ? rand(100, 5000) : null,
                    'precio_unitario' => $precio,
                    'importe' => $importe,
                    'orden' => $j,
                ]);
            }

            $iva = round($subtotal * 0.16, 2);
            $orden->update([
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $subtotal + $iva,
            ]);
        }

        $this->command->info('✅ 100 órdenes de compra de prueba creadas');
    }
}
