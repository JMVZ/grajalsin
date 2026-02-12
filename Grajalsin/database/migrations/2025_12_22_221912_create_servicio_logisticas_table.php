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
        Schema::create('servicio_logisticas', function (Blueprint $table) {
            $table->id();
            
            // Folio único
            $table->string('folio')->unique();
            
            // Paso 1: Solicitud del cliente
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->enum('tipo_unidad', ['thermo', 'caja_seca', 'jaula', 'plataforma'])->default('caja_seca');
            $table->enum('tipo_carga', ['simple', 'completa'])->default('simple');
            
            // Paso 2: Contacto con línea de transporte (nullable porque se completa en paso 2)
            $table->foreignId('linea_carga_id')->nullable()->constrained('lineas_carga')->onDelete('cascade');
            $table->decimal('tarifa', 10, 2)->nullable();
            $table->decimal('comision_porcentaje', 5, 2)->nullable();
            $table->decimal('comision_monto', 10, 2)->nullable();
            
            // Paso 3: Datos de la orden de carga (formato DATOS DE CARGA)
            // Datos del operador/chofer
            $table->foreignId('chofer_id')->nullable()->constrained('choferes')->onDelete('set null');
            $table->string('operador_nombre')->nullable();
            $table->string('operador_celular')->nullable();
            $table->string('operador_licencia_numero')->nullable();
            $table->string('operador_expediente_medico')->nullable();
            $table->string('operador_curp_rfc')->nullable();
            
            // Datos del vehículo
            $table->string('placa_tractor')->nullable();
            $table->string('placa_remolque')->nullable();
            $table->string('modelo_color')->nullable();
            $table->string('poliza_compania')->nullable();
            
            // Datos de la carga
            $table->foreignId('destino_id')->nullable()->constrained('destinos')->onDelete('set null');
            $table->string('destino_carga')->nullable();
            $table->string('bodega')->nullable();
            $table->string('criba')->nullable();
            
            // Datos del cliente/empresa
            $table->string('cliente_empresa')->nullable();
            
            // Coordinador
            $table->string('coordinador_nombre')->nullable();
            $table->string('coordinador_numero')->nullable();
            
            // Fechas
            $table->date('fecha')->nullable();
            $table->date('fecha_carga')->nullable();
            $table->date('fecha_destino')->nullable();
            
            // Paso 4: Monitoreo y pago
            $table->enum('estado', ['solicitado', 'en_contacto', 'orden_preparada', 'en_transito', 'en_destino', 'comision_pagada', 'completado'])->default('solicitado');
            $table->boolean('comision_pagada')->default(false);
            $table->date('fecha_pago_comision')->nullable();
            $table->text('notas_monitoreo')->nullable();
            
            // Paso 5: Carga de retorno
            $table->boolean('tiene_carga_retorno')->default(false);
            $table->unsignedBigInteger('servicio_retorno_id')->nullable();
            $table->text('notas_retorno')->nullable();
            
            // Información interna
            $table->string('clave_interna')->nullable();
            $table->text('notas_internas')->nullable();
            
            // Usuario que creó el servicio
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });

        // Agregar foreign key para servicio_retorno_id después de crear la tabla
        Schema::table('servicio_logisticas', function (Blueprint $table) {
            $table->foreign('servicio_retorno_id')->references('id')->on('servicio_logisticas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_logisticas');
    }
};
