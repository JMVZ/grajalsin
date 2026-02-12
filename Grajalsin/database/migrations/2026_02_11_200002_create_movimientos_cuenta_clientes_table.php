<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_cuenta_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->date('fecha');
            $table->enum('tipo', ['cargo', 'abono']);
            $table->string('concepto', 100)->comment('venta, pago, ajuste, nota_credito');
            $table->decimal('monto', 14, 2);
            $table->string('referencia_tipo', 100)->nullable()->comment('PedidoVenta, PagoCliente');
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->text('notas')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['cliente_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_cuenta_clientes');
    }
};
