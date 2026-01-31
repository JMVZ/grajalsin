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
        Schema::create('pre_ordenes', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->nullable();
            $table->date('fecha');
            
            // Operador / Chofer
            $table->foreignId('chofer_id')->constrained('choferes');
            
            // Vehículo
            $table->string('placa_tractor');
            $table->string('placa_remolque');
            $table->string('modelo')->nullable();
            
            // Línea de transporte
            $table->foreignId('linea_carga_id')->constrained('lineas_carga');
            $table->string('poliza_seguro')->nullable();
            
            // Destino y tarifa
            $table->foreignId('destino_id')->constrained('destinos');
            $table->decimal('tarifa', 10, 2);
            
            // Tipo de carga
            $table->string('granel')->nullable(); // Ej: 50 toneladas
            $table->string('costal')->nullable(); // Ej: X
            
            // Cliente
            $table->foreignId('cliente_id')->constrained('clientes');
            
            // Bodega
            $table->foreignId('bodega_id')->constrained('bodegas');
            
            // Información interna
            $table->string('coordinador_nombre')->nullable();
            $table->string('coordinador_telefono')->nullable();
            $table->string('constancia_fiscal')->nullable();
            $table->string('base_linea')->nullable();
            $table->decimal('precio_factura', 10, 2)->nullable();
            
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_ordenes');
    }
};
