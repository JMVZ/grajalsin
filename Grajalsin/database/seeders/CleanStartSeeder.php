<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CleanStartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos básicos
        $permissions = [
            'view-dashboard',
            'manage-modules',
            'manage-users',
            'manage-roles'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear rol de Administrador
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        
        // Asignar todos los permisos al administrador
        $adminRole->givePermissionTo(Permission::all());

        // Crear usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@grajalsin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
            ]
        );

        // Asignar rol de administrador
        $admin->assignRole('Administrador');

        $this->command->info('✅ Usuario administrador creado exitosamente');
        $this->command->info('📧 Email: admin@grajalsin.com');
        $this->command->info('🔑 Contraseña: admin123');
        $this->command->info('');
        $this->command->info('🎯 Ahora puedes crear tus propios módulos y asignarlos a los usuarios');
    }
}

