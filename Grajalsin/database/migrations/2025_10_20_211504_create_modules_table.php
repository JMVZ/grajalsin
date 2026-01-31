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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del módulo (ej: "Inventario", "Ventas")
            $table->string('slug')->unique(); // Slug único (ej: "inventario", "ventas")
            $table->string('description')->nullable(); // Descripción del módulo
            $table->string('icon')->nullable(); // Icono del módulo
            $table->string('route')->nullable(); // Ruta del módulo
            $table->integer('order')->default(0); // Orden de aparición en el menú
            $table->boolean('is_active')->default(true); // Si el módulo está activo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
