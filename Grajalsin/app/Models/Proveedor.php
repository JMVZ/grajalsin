<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'rfc',
        'contacto',
        'celular',
        'telefono',
        'email',
        'direccion',
        'notas',
        'estatus',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];

    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('estatus', true);
    }

    public function movimientosCuenta()
    {
        return $this->hasMany(MovimientoCuentaProveedor::class)->orderBy('fecha')->orderBy('id');
    }

    public function pagos()
    {
        return $this->hasMany(PagoProveedor::class)->orderByDesc('fecha');
    }

    /** Saldo a favor del proveedor (lo que Grajalsin les debe). Cargos - Abonos. */
    public function getSaldoCuentaAttribute(): float
    {
        $cargos = (float) $this->movimientosCuenta()->where('tipo', 'cargo')->sum('monto');
        $abonos = (float) $this->movimientosCuenta()->where('tipo', 'abono')->sum('monto');
        return round($cargos - $abonos, 2);
    }
}
