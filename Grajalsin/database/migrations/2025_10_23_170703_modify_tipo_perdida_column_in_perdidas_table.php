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
        Schema::table('perdidas', function (Blueprint $table) {
            // Modificar la columna tipo_perdida de enum a string para permitir texto libre
            $table->string('tipo_perdida')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perdidas', function (Blueprint $table) {
            // Revertir a enum si es necesario (opcional)
            // Nota: Esto podría causar problemas si hay valores que no están en el enum
        });
    }
};
