<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Module;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos básicos
        $permissions = [
            'view-dashboard',
            'view-inventario',
            'create-inventario',
            'edit-inventario',
            'delete-inventario',
            'view-ventas',
            'create-ventas',
            'edit-ventas',
            'delete-ventas',
            'view-compras',
            'create-compras',
            'edit-compras',
            'delete-compras',
            'view-reportes',
            'view-usuarios',
            'create-usuarios',
            'edit-usuarios',
            'delete-usuarios',
            'manage-roles',
            'manage-modules'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $vendedorRole = Role::firstOrCreate(['name' => 'Vendedor']);
        $almacenistaRole = Role::firstOrCreate(['name' => 'Almacenista']);
        $contadorRole = Role::firstOrCreate(['name' => 'Contador']);

        // Asignar todos los permisos al administrador
        $adminRole->givePermissionTo(Permission::all());

        // Asignar permisos específicos a vendedor
        $vendedorRole->givePermissionTo([
            'view-dashboard',
            'view-inventario',
            'view-ventas',
            'create-ventas',
            'edit-ventas',
            'view-reportes'
        ]);

        // Asignar permisos específicos a almacenista
        $almacenistaRole->givePermissionTo([
            'view-dashboard',
            'view-inventario',
            'create-inventario',
            'edit-inventario',
            'view-compras',
            'create-compras',
            'edit-compras'
        ]);

        // Asignar permisos específicos a contador
        $contadorRole->givePermissionTo([
            'view-dashboard',
            'view-ventas',
            'view-compras',
            'view-reportes'
        ]);

        // Crear módulos del sistema
        $modules = [
            [
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'description' => 'Panel principal con estadísticas',
                'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z',
                'route' => 'dashboard',
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Inventario',
                'slug' => 'inventario',
                'description' => 'Gestión de inventario de granos',
                'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                'route' => 'inventario.index',
                'order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Ventas',
                'slug' => 'ventas',
                'description' => 'Gestión de ventas de granos',
                'icon' => 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                'route' => 'ventas.index',
                'order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Compras',
                'slug' => 'compras',
                'description' => 'Gestión de compras (insumos y granos)',
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1',
                'route' => 'compras.index',
                'order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Reportes',
                'slug' => 'reportes',
                'description' => 'Reportes y estadísticas',
                'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                'route' => 'reportes.index',
                'order' => 5,
                'is_active' => false
            ],
            [
                'name' => 'Usuarios',
                'slug' => 'usuarios',
                'description' => 'Gestión de usuarios del sistema',
                'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z',
                'route' => 'usuarios.index',
                'order' => 6,
                'is_active' => false
            ],
            [
                'name' => 'Logística CATTA',
                'slug' => 'logistica-catta',
                'description' => 'Servicios de logística en transporte de carga pesada',
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'route' => 'servicio-logistica.index',
                'order' => 7,
                'is_active' => true
            ]
        ];

        foreach ($modules as $moduleData) {
            Module::updateOrCreate(['slug' => $moduleData['slug']], $moduleData);
        }

        // Asignar módulos a roles usando la tabla pivot directamente
        $dashboardModule = Module::where('slug', 'dashboard')->first();
        $inventarioModule = Module::where('slug', 'inventario')->first();
        $ventasModule = Module::where('slug', 'ventas')->first();
        $comprasModule = Module::where('slug', 'compras')->first();
        $reportesModule = Module::where('slug', 'reportes')->first();
        $usuariosModule = Module::where('slug', 'usuarios')->first();
        $logisticaModule = Module::where('slug', 'logistica-catta')->first();

        // Verificar y asignar módulos a roles si no existen
        $roleModuleData = [
            // Administrador tiene acceso a todos los módulos
            [$adminRole->id, $dashboardModule->id],
            [$adminRole->id, $inventarioModule->id],
            [$adminRole->id, $ventasModule->id],
            [$adminRole->id, $comprasModule->id],
            [$adminRole->id, $reportesModule->id],
            [$adminRole->id, $usuariosModule->id],
            [$adminRole->id, $logisticaModule->id],
            // Vendedor tiene acceso a dashboard, inventario, ventas y reportes
            [$vendedorRole->id, $dashboardModule->id],
            [$vendedorRole->id, $inventarioModule->id],
            [$vendedorRole->id, $ventasModule->id],
            [$vendedorRole->id, $reportesModule->id],
            // Almacenista tiene acceso a dashboard, inventario y compras
            [$almacenistaRole->id, $dashboardModule->id],
            [$almacenistaRole->id, $inventarioModule->id],
            [$almacenistaRole->id, $comprasModule->id],
            // Contador tiene acceso a dashboard, ventas, compras y reportes
            [$contadorRole->id, $dashboardModule->id],
            [$contadorRole->id, $ventasModule->id],
            [$contadorRole->id, $comprasModule->id],
            [$contadorRole->id, $reportesModule->id],
        ];

        foreach ($roleModuleData as $data) {
            \DB::table('role_module')->insertOrIgnore([
                'role_id' => $data[0],
                'module_id' => $data[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Asignar rol de administrador al usuario admin existente
        $adminUser = User::where('email', 'admin@grajalsin.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('Administrador');
        }
    }
}
