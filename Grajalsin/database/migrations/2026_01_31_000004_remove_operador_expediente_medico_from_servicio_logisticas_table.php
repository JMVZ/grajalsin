<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servicio_logisticas', function (Blueprint $table) {
            $table->dropColumn('operador_expediente_medico');
        });
    }

    public function down(): void
    {
        Schema::table('servicio_logisticas', function (Blueprint $table) {
            $table->string('operador_expediente_medico')->nullable()->after('operador_licencia_numero');
        });
    }
};
