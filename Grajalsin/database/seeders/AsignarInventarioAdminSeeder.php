<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\User;

class AsignarInventarioAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@grajalsin.com')->first();
        $inventarioModule = Module::where('slug', 'inventario')->first();
        
        if ($admin && $inventarioModule) {
            $admin->modules()->syncWithoutDetaching([$inventarioModule->id]);
            $this->command->info('✅ Módulo de Inventario asignado al administrador');
        } else {
            $this->command->error('❌ No se encontró el usuario admin o el módulo de inventario');
        }
    }
}

