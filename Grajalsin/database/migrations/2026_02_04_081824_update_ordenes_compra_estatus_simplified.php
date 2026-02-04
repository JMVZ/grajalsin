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
        // Cambiar estados antiguos a 'activa' antes de modificar el enum
        \DB::statement("UPDATE ordenes_compra SET estatus = 'activa' WHERE estatus IN ('borrador', 'enviada', 'recibida')");
        
        Schema::table('ordenes_compra', function (Blueprint $table) {
            $table->dropColumn('estatus');
        });
        
        Schema::table('ordenes_compra', function (Blueprint $table) {
            $table->enum('estatus', ['activa', 'cancelada'])->default('activa')->after('notas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convertir 'activa' a 'borrador' y mantener 'cancelada'
        \DB::statement("UPDATE ordenes_compra SET estatus = 'borrador' WHERE estatus = 'activa'");
        
        Schema::table('ordenes_compra', function (Blueprint $table) {
            $table->dropColumn('estatus');
        });
        
        Schema::table('ordenes_compra', function (Blueprint $table) {
            $table->enum('estatus', ['borrador', 'enviada', 'recibida', 'cancelada'])->default('borrador')->after('notas');
        });
    }
};
