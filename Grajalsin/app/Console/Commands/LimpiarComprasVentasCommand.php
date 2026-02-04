<?php

namespace App\Console\Commands;

use App\Models\Movimiento;
use App\Models\OrdenCompra;
use App\Models\PedidoVenta;
use App\Models\Proveedor;
use Illuminate\Console\Command;

class LimpiarComprasVentasCommand extends Command
{
    protected $signature = 'limpiar:compras-ventas {--confirmar : Confirmar sin preguntar}';
    protected $description = 'Elimina todos los proveedores, órdenes de compra y pedidos de venta';

    public function handle()
    {
        if (!$this->option('confirmar')) {
            if (!$this->confirm('¿Estás seguro de que quieres eliminar TODOS los proveedores, compras y ventas? Esta acción no se puede deshacer.')) {
                $this->info('Operación cancelada.');
                return 0;
            }
        }

        $this->info('🧹 Limpiando datos...');

        // 1. Eliminar movimientos relacionados con órdenes de compra
        $this->info('Eliminando movimientos de inventario relacionados con compras...');
        $foliosCompras = OrdenCompra::pluck('folio')->toArray();
        $movimientosEliminados = Movimiento::whereIn('referencia', $foliosCompras)
            ->orWhere('motivo', 'compra')
            ->orWhere(function($q) use ($foliosCompras) {
                foreach ($foliosCompras as $folio) {
                    $q->orWhere('notas', 'like', "%{$folio}%");
                }
            })
            ->delete();
        $this->info("   ✓ {$movimientosEliminados} movimientos eliminados");

        // 2. Eliminar líneas de órdenes de compra
        $this->info('Eliminando líneas de órdenes de compra...');
        $lineasEliminadas = \DB::table('orden_compra_lineas')->delete();
        $this->info("   ✓ {$lineasEliminadas} líneas eliminadas");

        // 3. Eliminar órdenes de compra
        $this->info('Eliminando órdenes de compra...');
        $ordenesEliminadas = OrdenCompra::count();
        OrdenCompra::query()->delete();
        $this->info("   ✓ {$ordenesEliminadas} órdenes de compra eliminadas");

        // 4. Eliminar pedidos de venta
        $this->info('Eliminando pedidos de venta...');
        $pedidosEliminados = PedidoVenta::count();
        PedidoVenta::query()->delete();
        $this->info("   ✓ {$pedidosEliminados} pedidos de venta eliminados");

        // 5. Eliminar proveedores
        $this->info('Eliminando proveedores...');
        $proveedoresEliminados = Proveedor::count();
        Proveedor::query()->delete();
        $this->info("   ✓ {$proveedoresEliminados} proveedores eliminados");

        $this->info('');
        $this->info('✅ Limpieza completada exitosamente.');
        $this->info('');
        $this->info('Resumen:');
        $this->info("   - Movimientos eliminados: {$movimientosEliminados}");
        $this->info("   - Líneas de compra eliminadas: {$lineasEliminadas}");
        $this->info("   - Órdenes de compra eliminadas: {$ordenesEliminadas}");
        $this->info("   - Pedidos de venta eliminados: {$pedidosEliminados}");
        $this->info("   - Proveedores eliminados: {$proveedoresEliminados}");

        return 0;
    }
}
