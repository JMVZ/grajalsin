<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Chofer;
use App\Models\Bodega;
use App\Models\Destino;
use App\Models\LineaCarga;
use App\Models\Movimiento;
use Carbon\Carbon;

class DatosEjemploSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Creando datos de ejemplo...');

        // Crear Productos
        $this->command->info('📦 Creando productos...');
        $productos = [
            [
                'nombre' => 'Maíz Amarillo',
                'codigo' => 'MAZ-001',
                'descripcion' => 'Maíz amarillo de alta calidad',
                'unidad_medida' => 'toneladas',
                'maneja_stock' => true,
                'stock_actual' => 150.50,
                'stock_minimo' => 20.00,
                'stock_maximo' => 200.00,
                'precio_compra' => 4500.00,
                'precio_venta' => 5200.00,
                'ubicacion' => 'Bodega Principal',
                'activo' => true,
            ],
            [
                'nombre' => 'Trigo',
                'codigo' => 'TRG-001',
                'descripcion' => 'Trigo para molienda',
                'unidad_medida' => 'toneladas',
                'maneja_stock' => true,
                'stock_actual' => 85.25,
                'stock_minimo' => 15.00,
                'stock_maximo' => 150.00,
                'precio_compra' => 4800.00,
                'precio_venta' => 5500.00,
                'ubicacion' => 'Bodega Principal',
                'activo' => true,
            ],
            [
                'nombre' => 'Sorgo',
                'codigo' => 'SRG-001',
                'descripcion' => 'Sorgo para forraje',
                'unidad_medida' => 'toneladas',
                'maneja_stock' => true,
                'stock_actual' => 200.00,
                'stock_minimo' => 30.00,
                'stock_maximo' => 250.00,
                'precio_compra' => 4200.00,
                'precio_venta' => 4900.00,
                'ubicacion' => 'Bodega Secundaria',
                'activo' => true,
            ],
            [
                'nombre' => 'Frijol',
                'codigo' => 'FRJ-001',
                'descripcion' => 'Frijol negro',
                'unidad_medida' => 'quintales',
                'maneja_stock' => true,
                'stock_actual' => 500.00,
                'stock_minimo' => 100.00,
                'stock_maximo' => 800.00,
                'precio_compra' => 850.00,
                'precio_venta' => 1200.00,
                'ubicacion' => 'Bodega Principal',
                'activo' => true,
            ],
            [
                'nombre' => 'Avena',
                'codigo' => 'AVN-001',
                'descripcion' => 'Avena para consumo',
                'unidad_medida' => 'toneladas',
                'maneja_stock' => true,
                'stock_actual' => 45.75,
                'stock_minimo' => 10.00,
                'stock_maximo' => 100.00,
                'precio_compra' => 5000.00,
                'precio_venta' => 5800.00,
                'ubicacion' => 'Bodega Principal',
                'activo' => true,
            ],
        ];

        foreach ($productos as $producto) {
            Producto::firstOrCreate(['codigo' => $producto['codigo']], $producto);
        }
        $this->command->info('✅ ' . count($productos) . ' productos creados');

        // Crear Bodegas
        $this->command->info('🏭 Creando bodegas...');
        $bodegas = [
            [
                'nombre' => 'Bodega Principal',
                'ubicacion' => 'Carretera Principal Km 12',
                'estatus' => true,
                'notas' => 'Bodega principal de almacenamiento',
            ],
            [
                'nombre' => 'Bodega Secundaria',
                'ubicacion' => 'Avenida Industrial 456',
                'estatus' => true,
                'notas' => 'Bodega secundaria para productos adicionales',
            ],
            [
                'nombre' => 'Bodega Norte',
                'ubicacion' => 'Zona Industrial Norte',
                'estatus' => true,
                'notas' => 'Bodega en zona norte de la ciudad',
            ],
        ];

        foreach ($bodegas as $bodega) {
            Bodega::firstOrCreate(['nombre' => $bodega['nombre']], $bodega);
        }
        $this->command->info('✅ ' . count($bodegas) . ' bodegas creadas');

        // Crear Clientes
        $this->command->info('👥 Creando clientes...');
        $clientes = [
            [
                'nombre' => 'Molinos del Norte S.A. de C.V.',
                'codigo' => 'CLI-001',
                'rfc' => 'MON850101ABC',
                'contacto' => 'Juan Pérez',
                'telefono' => '5551234567',
                'email' => 'contacto@molinosdelnorte.com',
                'direccion' => 'Av. Industrial 123, Col. Centro',
                'estatus' => true,
                'notas' => 'Cliente principal de maíz y trigo',
            ],
            [
                'nombre' => 'Distribuidora de Granos México',
                'codigo' => 'CLI-002',
                'rfc' => 'DGM900201XYZ',
                'contacto' => 'María González',
                'telefono' => '5559876543',
                'email' => 'ventas@distribuidoragranos.com',
                'direccion' => 'Blvd. Comercial 456',
                'estatus' => true,
                'notas' => 'Cliente frecuente de sorgo',
            ],
            [
                'nombre' => 'Alimentos del Campo',
                'codigo' => 'CLI-003',
                'rfc' => 'ADC750301MNO',
                'contacto' => 'Carlos Ramírez',
                'telefono' => '5554567890',
                'email' => 'compras@alimentosdelcampo.com',
                'direccion' => 'Calle Agrícola 789',
                'estatus' => true,
                'notas' => 'Cliente de frijol y avena',
            ],
            [
                'nombre' => 'Comercializadora de Granos',
                'codigo' => 'CLI-004',
                'rfc' => 'CGR820401PQR',
                'contacto' => 'Ana Martínez',
                'telefono' => '5553210987',
                'email' => 'info@comercializadoragranos.com',
                'direccion' => 'Av. Comercial 321',
                'estatus' => true,
                'notas' => 'Cliente nuevo',
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::firstOrCreate(['codigo' => $cliente['codigo']], $cliente);
        }
        $this->command->info('✅ ' . count($clientes) . ' clientes creados');

        // Crear Choferes
        $this->command->info('🚛 Creando choferes...');
        $choferes = [
            [
                'nombre' => 'José Luis Hernández',
                'telefono' => '5551112233',
                'curp' => 'HEJL800101HDFRNS01',
                'licencia_numero' => 'LIC123456',
                'licencia_tipo' => 'Tipo A',
                'licencia_vence' => Carbon::now()->addMonths(6),
                'estatus' => true,
                'notas' => 'Chofer con 10 años de experiencia',
            ],
            [
                'nombre' => 'Roberto Sánchez',
                'telefono' => '5552223344',
                'curp' => 'SARB850202HDFRNS02',
                'licencia_numero' => 'LIC234567',
                'licencia_tipo' => 'Tipo A',
                'licencia_vence' => Carbon::now()->addMonths(8),
                'estatus' => true,
                'notas' => 'Chofer especializado en rutas largas',
            ],
            [
                'nombre' => 'Miguel Ángel Torres',
                'telefono' => '5553334455',
                'curp' => 'TOMM900303HDFRNS03',
                'licencia_numero' => 'LIC345678',
                'licencia_tipo' => 'Tipo B',
                'licencia_vence' => Carbon::now()->addMonths(4),
                'estatus' => true,
                'notas' => 'Chofer nuevo en la empresa',
            ],
            [
                'nombre' => 'Francisco Javier López',
                'telefono' => '5554445566',
                'curp' => 'LOFF880404HDFRNS04',
                'licencia_numero' => 'LIC456789',
                'licencia_tipo' => 'Tipo A',
                'licencia_vence' => Carbon::now()->addMonths(12),
                'estatus' => true,
                'notas' => 'Chofer con excelente historial',
            ],
        ];

        foreach ($choferes as $chofer) {
            Chofer::firstOrCreate(['curp' => $chofer['curp']], $chofer);
        }
        $this->command->info('✅ ' . count($choferes) . ' choferes creados');

        // Crear Destinos
        $this->command->info('📍 Creando destinos...');
        $destinos = [
            [
                'nombre' => 'Ciudad de México',
                'estatus' => true,
                'notas' => 'Destino principal - CDMX',
            ],
            [
                'nombre' => 'Guadalajara, Jalisco',
                'estatus' => true,
                'notas' => 'Destino a Guadalajara',
            ],
            [
                'nombre' => 'Monterrey, Nuevo León',
                'estatus' => true,
                'notas' => 'Destino a Monterrey',
            ],
            [
                'nombre' => 'Puebla, Puebla',
                'estatus' => true,
                'notas' => 'Destino a Puebla',
            ],
            [
                'nombre' => 'Querétaro, Querétaro',
                'estatus' => true,
                'notas' => 'Destino a Querétaro',
            ],
        ];

        foreach ($destinos as $destino) {
            Destino::firstOrCreate(['nombre' => $destino['nombre']], $destino);
        }
        $this->command->info('✅ ' . count($destinos) . ' destinos creados');

        // Crear Líneas de Carga
        $this->command->info('🚚 Creando líneas de carga...');
        $lineasCarga = [
            [
                'nombre' => 'Transportes Rápidos del Norte',
                'contacto' => 'Pedro Martínez',
                'base_operacion' => 'Ciudad de México',
                'estatus' => true,
                'notas' => 'Línea de carga principal',
            ],
            [
                'nombre' => 'Carga y Transporte Express',
                'contacto' => 'Luis Fernández',
                'base_operacion' => 'Guadalajara',
                'estatus' => true,
                'notas' => 'Línea especializada en rutas cortas',
            ],
            [
                'nombre' => 'Logística Nacional',
                'contacto' => 'Fernando García',
                'base_operacion' => 'Monterrey',
                'estatus' => true,
                'notas' => 'Línea para rutas largas',
            ],
        ];

        foreach ($lineasCarga as $linea) {
            LineaCarga::firstOrCreate(['nombre' => $linea['nombre']], $linea);
        }
        $this->command->info('✅ ' . count($lineasCarga) . ' líneas de carga creadas');

        // Crear algunos movimientos de ejemplo
        $this->command->info('📊 Creando movimientos de ejemplo...');
        $productos = Producto::all();
        $adminUser = \App\Models\User::where('email', 'admin@grajalsin.com')->first();

        if ($productos->count() > 0 && $adminUser) {
            $movimientos = [
                [
                    'producto_id' => $productos->first()->id,
                    'tipo' => 'entrada',
                    'cantidad' => 50.00,
                    'precio_unitario' => 4500.00,
                    'total' => 225000.00,
                    'fecha_movimiento' => Carbon::now()->subDays(5),
                    'motivo' => 'compra',
                    'referencia' => 'FAC-001',
                    'notas' => 'Compra de maíz para inventario',
                    'ubicacion_destino' => 'Bodega Principal',
                    'user_id' => $adminUser->id,
                ],
                [
                    'producto_id' => $productos->skip(1)->first()->id,
                    'tipo' => 'entrada',
                    'cantidad' => 30.00,
                    'precio_unitario' => 4800.00,
                    'total' => 144000.00,
                    'fecha_movimiento' => Carbon::now()->subDays(3),
                    'motivo' => 'compra',
                    'referencia' => 'FAC-002',
                    'notas' => 'Compra de trigo',
                    'ubicacion_destino' => 'Bodega Principal',
                    'user_id' => $adminUser->id,
                ],
                [
                    'producto_id' => $productos->first()->id,
                    'tipo' => 'salida',
                    'cantidad' => 25.00,
                    'precio_unitario' => 5200.00,
                    'total' => 130000.00,
                    'fecha_movimiento' => Carbon::now()->subDays(2),
                    'motivo' => 'venta',
                    'referencia' => 'VTA-001',
                    'notas' => 'Venta de maíz a cliente',
                    'ubicacion_origen' => 'Bodega Principal',
                    'user_id' => $adminUser->id,
                ],
            ];

            foreach ($movimientos as $movimiento) {
                Movimiento::create($movimiento);
            }
            $this->command->info('✅ ' . count($movimientos) . ' movimientos creados');
        }

        $this->command->info('');
        $this->command->info('✅ Datos de ejemplo creados exitosamente!');
        $this->command->info('');
        $this->command->info('📊 Resumen:');
        $this->command->info('   - Productos: ' . Producto::count());
        $this->command->info('   - Clientes: ' . Cliente::count());
        $this->command->info('   - Choferes: ' . Chofer::count());
        $this->command->info('   - Bodegas: ' . Bodega::count());
        $this->command->info('   - Destinos: ' . Destino::count());
        $this->command->info('   - Líneas de Carga: ' . LineaCarga::count());
        $this->command->info('   - Movimientos: ' . Movimiento::count());
    }
}

