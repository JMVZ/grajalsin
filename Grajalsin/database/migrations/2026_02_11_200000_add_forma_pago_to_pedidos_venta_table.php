<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos_venta', function (Blueprint $table) {
            $table->string('forma_pago', 20)->default('contado')->after('estatus')
                ->comment('contado = no carga a estado de cuenta; crédito = sí carga a cobranza');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos_venta', function (Blueprint $table) {
            $table->dropColumn('forma_pago');
        });
    }
};
