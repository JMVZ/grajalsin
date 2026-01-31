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
        // Crear tabla pivot para productos en pre-órdenes
        Schema::create('pre_orden_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pre_orden_id')->constrained('pre_ordenes')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->decimal('cantidad', 10, 2);
            $table->string('tipo_carga'); // 'granel' o 'costal'
            $table->decimal('toneladas', 10, 2)->nullable(); // Para granel
            $table->timestamps();
        });

        // Eliminar los campos antiguos de granel y costal de pre_ordenes
        Schema::table('pre_ordenes', function (Blueprint $table) {
            $table->dropColumn('granel');
        });
        Schema::table('pre_ordenes', function (Blueprint $table) {
            $table->dropColumn('costal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_orden_producto');
        
        Schema::table('pre_ordenes', function (Blueprint $table) {
            $table->string('granel')->nullable();
            $table->string('costal')->nullable();
        });
    }
};
