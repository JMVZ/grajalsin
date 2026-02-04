<?php

namespace App\Console\Commands;

use App\Models\OrdenCompra;
use App\Models\Proveedor;
use Illuminate\Console\Command;

class LimpiarComprasCommand extends Command
{
    protected $signature = 'compras:limpiar {--confirm : Ejecutar sin pedir confirmación}';

    protected $description = 'Elimina todas las órdenes de compra y proveedores';

    public function handle(): int
    {
        if (!$this->option('confirm') && !$this->confirm('¿Eliminar TODAS las órdenes de compra y proveedores? Esta acción no se puede deshacer.')) {
            $this->info('Operación cancelada');
            return Command::SUCCESS;
        }

        $ordenes = OrdenCompra::count();
        $proveedores = Proveedor::count();

        OrdenCompra::query()->delete(); // Las líneas se eliminan por cascade
        Proveedor::query()->delete();

        $this->info("✅ Eliminados: {$ordenes} órdenes de compra, {$proveedores} proveedores");

        return Command::SUCCESS;
    }
}
