<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos_venta', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->date('fecha');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('restrict');
            $table->decimal('toneladas', 12, 2);
            $table->decimal('precio_venta', 14, 2);
            $table->decimal('tarifa_flete', 14, 2)->default(0);
            $table->foreignId('bodega_id')->constrained('bodegas')->onDelete('restrict');
            $table->foreignId('destino_id')->constrained('destinos')->onDelete('restrict');
            $table->foreignId('producto_id')->nullable()->constrained('productos')->nullOnDelete()->comment('Tipo de costal');
            $table->date('fecha_entrega');
            $table->enum('estatus', ['activa', 'cancelada'])->default('activa');
            $table->text('notas')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos_venta');
    }
};
