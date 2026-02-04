<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_compra', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['insumos', 'granos']);
            $table->string('folio')->unique();
            $table->date('fecha');
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('restrict');
            $table->string('forma_pago')->nullable();
            $table->string('uso_cfdi')->nullable();
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('iva', 14, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);
            $table->string('elaborado_por')->nullable();
            $table->string('solicitado_por')->nullable();
            $table->text('notas')->nullable();
            $table->enum('estatus', ['borrador', 'enviada', 'recibida', 'cancelada'])->default('borrador');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_compra');
    }
};
