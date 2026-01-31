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
        Schema::create('ordenes_carga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pre_orden_id')->constrained('pre_ordenes')->cascadeOnDelete();
            $table->string('folio')->unique();
            $table->date('fecha_entrada');
            $table->string('origen')->nullable();
            $table->string('bodega')->nullable();
            $table->string('destino')->nullable();
            $table->string('peso')->nullable();
            $table->string('producto')->nullable();
            $table->string('presentacion')->nullable();
            $table->string('costal')->nullable();
            $table->text('observaciones')->nullable();

            $table->string('operador_nombre');
            $table->string('operador_celular')->nullable();
            $table->string('operador_licencia')->nullable();
            $table->string('operador_curp')->nullable();
            $table->string('placas_camion')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('linea')->nullable();
            $table->string('poliza')->nullable();
            $table->string('referencia')->nullable();

            $table->string('elaboro_nombre');
            $table->string('elaboro_celular')->nullable();
            $table->string('recibe_nombre')->nullable();
            $table->string('recibe_celular')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_carga');
    }
};


