<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCuentaCliente extends Model
{
    protected $table = 'movimientos_cuenta_clientes';

    protected $fillable = [
        'cliente_id',
        'fecha',
        'tipo',
        'concepto',
        'monto',
        'referencia_tipo',
        'referencia_id',
        'notas',
        'user_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
