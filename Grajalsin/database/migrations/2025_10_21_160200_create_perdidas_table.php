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
        Schema::create('perdidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            
            $table->decimal('cantidad', 12, 2); // Cantidad perdida
            
            // Tipo de pérdida (campo abierto de texto)
            $table->string('tipo_perdida'); // Tipo de pérdida (ej: Humedad, Plaga, Derrame, etc.)
            
            $table->string('ubicacion')->nullable(); // Dónde ocurrió la pérdida
            $table->text('descripcion')->nullable(); // Descripción detallada
            $table->text('acciones_tomadas')->nullable(); // ¿Qué se hizo al respecto?
            
            $table->decimal('valor_estimado', 10, 2)->nullable(); // Valor de la pérdida
            
            // Evidencia
            $table->string('evidencia_foto')->nullable(); // Ruta de la foto
            
            // Usuario responsable del registro
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamp('fecha_deteccion')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perdidas');
    }
};

