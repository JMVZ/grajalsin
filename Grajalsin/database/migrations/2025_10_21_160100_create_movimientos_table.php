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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            
            // Tipo de movimiento
            $table->enum('tipo', ['entrada', 'salida']); // entrada (+) o salida (-)
            
            // Motivo del movimiento
            $table->enum('motivo', [
                'compra',           // Compra a proveedor
                'venta',            // Venta a cliente
                'devolucion_cliente', // Cliente devuelve
                'devolucion_proveedor', // Devolvemos a proveedor
                'ajuste_inventario', // Ajuste por conteo físico
                'transferencia',    // Entre bodegas
                'otro'
            ]);
            
            $table->decimal('cantidad', 12, 2); // Cantidad del movimiento
            $table->decimal('precio_unitario', 10, 2)->nullable(); // Precio al que se compró/vendió
            $table->decimal('total', 12, 2)->nullable(); // cantidad * precio_unitario
            
            // Información adicional
            $table->string('lote')->nullable(); // Número de lote (trazabilidad)
            $table->string('referencia')->nullable(); // Factura, orden, etc.
            $table->text('notas')->nullable();
            
            // Ubicación
            $table->string('ubicacion_origen')->nullable();
            $table->string('ubicacion_destino')->nullable();
            
            // Usuario responsable
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamp('fecha_movimiento')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};

