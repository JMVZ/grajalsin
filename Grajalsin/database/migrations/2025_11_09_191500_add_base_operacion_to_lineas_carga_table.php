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
        Schema::table('lineas_carga', function (Blueprint $table) {
            $table->string('base_operacion')->nullable()->after('contacto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lineas_carga', function (Blueprint $table) {
            $table->dropColumn('base_operacion');
        });
    }
};


