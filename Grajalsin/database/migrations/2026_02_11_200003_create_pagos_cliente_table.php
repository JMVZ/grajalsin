<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos_cliente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('restrict');
            $table->date('fecha');
            $table->decimal('monto', 14, 2);
            $table->string('forma_pago', 100)->nullable()->comment('Transferencia, Efectivo, Cheque, etc.');
            $table->string('referencia', 255)->nullable()->comment('Referencia bancaria, folio, etc.');
            $table->text('notas')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['cliente_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos_cliente');
    }
};
