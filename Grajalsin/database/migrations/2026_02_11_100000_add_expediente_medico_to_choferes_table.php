<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('choferes', function (Blueprint $table) {
            $table->string('expediente_medico_numero')->nullable()->after('licencia_vence');
            $table->date('expediente_medico_vence')->nullable()->after('expediente_medico_numero');
        });
    }

    public function down(): void
    {
        Schema::table('choferes', function (Blueprint $table) {
            $table->dropColumn(['expediente_medico_numero', 'expediente_medico_vence']);
        });
    }
};
