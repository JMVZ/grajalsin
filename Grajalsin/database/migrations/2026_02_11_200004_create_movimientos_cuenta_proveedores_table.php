<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_cuenta_proveedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->date('fecha');
            $table->enum('tipo', ['cargo', 'abono']);
            $table->string('concepto', 100)->comment('compra, pago, ajuste');
            $table->decimal('monto', 14, 2);
            $table->string('referencia_tipo', 100)->nullable()->comment('OrdenCompra, PagoProveedor');
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->text('notas')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['proveedor_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_cuenta_proveedores');
    }
};
