<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\User;

class InventarioModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear módulo de inventario
        $inventarioModule = Module::firstOrCreate(
            ['slug' => 'inventario'],
            [
                'name' => 'Inventario',
                'description' => 'Gestión de inventario de granos',
                'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                'route' => 'inventario.index',
                'order' => 1,
                'is_active' => true
            ]
        );

        $this->command->info('✅ Módulo de Inventario creado');
        $this->command->info('📦 Puedes asignarlo a usuarios desde Gestión de Usuarios');
    }
}

