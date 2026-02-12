<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCuentaProveedor extends Model
{
    protected $table = 'movimientos_cuenta_proveedores';

    protected $fillable = [
        'proveedor_id',
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

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
