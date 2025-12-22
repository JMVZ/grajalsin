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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Maíz, Trigo, etc.
            $table->string('codigo')->unique()->nullable(); // Código del producto
            $table->text('descripcion')->nullable();
            $table->string('unidad_medida')->default('kg'); // kg, quintales, costales, toneladas
            
            // Control de stock
            $table->boolean('maneja_stock')->default(true); // TRUE = maneja stock, FALSE = siempre disponible (bajo pedido)
            $table->decimal('stock_actual', 12, 2)->default(0); // Solo si maneja_stock = true
            $table->decimal('stock_minimo', 12, 2)->nullable(); // Alerta cuando esté bajo
            $table->decimal('stock_maximo', 12, 2)->nullable(); // Alerta cuando esté alto
            
            // Precios
            $table->decimal('precio_compra', 10, 2)->nullable();
            $table->decimal('precio_venta', 10, 2)->nullable();
            
            // Ubicación
            $table->string('ubicacion')->nullable(); // Bodega A, Bodega B, etc.
            
            // Estado
            $table->boolean('activo')->default(true);
            $table->string('imagen')->nullable(); // Ruta de la imagen del grano
            
            $table->timestamps();
            $table->softDeletes(); // Para no perder historial
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

