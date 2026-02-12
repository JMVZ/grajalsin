<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordenes_compra', function (Blueprint $table) {
            $table->string('tipo_compra', 20)->default('contado')->after('forma_pago')
                ->comment('contado = no carga a estado de cuenta; crédito = sí carga a cuentas por pagar');
        });
    }

    public function down(): void
    {
        Schema::table('ordenes_compra', function (Blueprint $table) {
            $table->dropColumn('tipo_compra');
        });
    }
};
