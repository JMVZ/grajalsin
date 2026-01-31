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
        Schema::create('boletas_salida', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_carga_id')->constrained('ordenes_carga')->cascadeOnDelete()->unique();
            $table->string('folio')->unique();
            $table->date('fecha');

            // Datos del cliente y del producto
            $table->string('cliente_tipo')->nullable(); // PUBLICO EN GENERAL / otro
            $table->string('cliente_nombre');
            $table->string('cliente_rfc')->nullable();
            $table->string('producto');
            $table->string('variedad')->nullable();
            $table->string('cosecha')->nullable();
            $table->string('envase')->nullable();
            $table->string('origen')->nullable();
            $table->string('destino')->nullable();
            $table->string('referencia')->nullable();

            // Datos del operador y unidad
            $table->string('operador_nombre');
            $table->string('operador_celular')->nullable();
            $table->string('operador_licencia')->nullable();
            $table->string('operador_curp')->nullable();
            $table->string('camion')->nullable();
            $table->string('placas')->nullable();
            $table->string('poliza')->nullable();
            $table->string('linea')->nullable();

            // Análisis del producto
            $table->decimal('analisis_humedad', 5, 2)->nullable();
            $table->decimal('analisis_peso_especifico', 8, 2)->nullable();
            $table->decimal('analisis_impurezas', 5, 2)->nullable();
            $table->decimal('analisis_quebrado', 5, 2)->nullable();
            $table->decimal('analisis_danados', 5, 2)->nullable();
            $table->decimal('analisis_otros', 5, 2)->nullable();

            // Pesos de báscula
            $table->decimal('peso_bruto', 10, 2)->nullable();
            $table->decimal('peso_tara', 10, 2)->nullable();
            $table->decimal('peso_neto', 10, 2)->nullable();
            $table->decimal('peso_total', 10, 2)->nullable();

            // Notas y firmas
            $table->text('observaciones')->nullable();
            $table->text('notas')->nullable();
            $table->string('elaboro_nombre')->nullable();
            $table->string('firma_recibio_nombre')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boletas_salida');
    }
};
