<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Activar módulo Ventas para que aparezca en el menú
        DB::table('modules')->where('slug', 'ventas')->update(['is_active' => true]);

        // Asegurar que el usuario admin tenga is_admin = true (ve todos los módulos activos)
        DB::table('users')->where('email', 'admin@grajalsin.com')->update(['is_admin' => true]);
    }

    public function down(): void
    {
        DB::table('modules')->where('slug', 'ventas')->update(['is_active' => false]);
    }
};
