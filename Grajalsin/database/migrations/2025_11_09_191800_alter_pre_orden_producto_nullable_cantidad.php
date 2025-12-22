<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function () {
            Schema::create('pre_orden_producto_temp', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pre_orden_id')->constrained('pre_ordenes')->onDelete('cascade');
                $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
                $table->decimal('cantidad', 10, 2)->nullable();
                $table->string('tipo_carga');
                $table->decimal('toneladas', 10, 2)->nullable();
                $table->timestamps();
            });

            $registros = DB::table('pre_orden_producto')->orderBy('id')->get();

            foreach ($registros as $registro) {
                DB::table('pre_orden_producto_temp')->insert([
                    'id' => $registro->id,
                    'pre_orden_id' => $registro->pre_orden_id,
                    'producto_id' => $registro->producto_id,
                    'cantidad' => $registro->cantidad,
                    'tipo_carga' => $registro->tipo_carga,
                    'toneladas' => $registro->toneladas,
                    'created_at' => $registro->created_at,
                    'updated_at' => $registro->updated_at,
                ]);
            }

            Schema::drop('pre_orden_producto');
            Schema::rename('pre_orden_producto_temp', 'pre_orden_producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::transaction(function () {
            Schema::create('pre_orden_producto_temp', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pre_orden_id')->constrained('pre_ordenes')->onDelete('cascade');
                $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
                $table->decimal('cantidad', 10, 2);
                $table->string('tipo_carga');
                $table->decimal('toneladas', 10, 2)->nullable();
                $table->timestamps();
            });

            $registros = DB::table('pre_orden_producto')->orderBy('id')->get();

            foreach ($registros as $registro) {
                DB::table('pre_orden_producto_temp')->insert([
                    'id' => $registro->id,
                    'pre_orden_id' => $registro->pre_orden_id,
                    'producto_id' => $registro->producto_id,
                    'cantidad' => $registro->cantidad ?? 0,
                    'tipo_carga' => $registro->tipo_carga,
                    'toneladas' => $registro->toneladas,
                    'created_at' => $registro->created_at,
                    'updated_at' => $registro->updated_at,
                ]);
            }

            Schema::drop('pre_orden_producto');
            Schema::rename('pre_orden_producto_temp', 'pre_orden_producto');
        });
    }
};


