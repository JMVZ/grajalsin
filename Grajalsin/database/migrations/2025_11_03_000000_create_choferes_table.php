<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('choferes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono', 20)->nullable();
            $table->string('curp', 18)->nullable();
            $table->string('licencia_numero')->nullable();
            $table->string('licencia_tipo', 20)->nullable();
            $table->date('licencia_vence')->nullable();
            $table->string('expediente_medico_numero')->nullable();
            $table->date('expediente_medico_vence')->nullable();
            $table->boolean('estatus')->default(true); // true: Activo
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('choferes');
    }
};


