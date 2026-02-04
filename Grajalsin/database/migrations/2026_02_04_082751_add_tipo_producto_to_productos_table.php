<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->enum('tipo_producto', ['costal', 'grano'])->nullable()->after('nombre');
        });

        // Actualizar productos que empiezan con "costal" (case insensitive)
        \DB::statement("UPDATE productos SET tipo_producto = 'costal' WHERE LOWER(nombre) LIKE 'costal%'");
        
        // Los demás productos que no sean costales, marcarlos como grano por defecto
        \DB::statement("UPDATE productos SET tipo_producto = 'grano' WHERE tipo_producto IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('tipo_producto');
        });
    }
};
