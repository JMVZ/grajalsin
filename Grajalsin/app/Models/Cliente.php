<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'rfc',
        'contacto',
        'celular',
        'telefono',
        'email',
        'direccion',
        'estatus',
        'notas',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];

    /** Código siempre en mayúsculas (referencia bancaria). */
    public function setCodigoAttribute($value): void
    {
        $this->attributes['codigo'] = $value !== null ? mb_strtoupper((string) $value) : null;
    }

    /** Mostrar código en mayúsculas aunque en BD esté mezclado. */
    public function getCodigoAttribute($value): ?string
    {
        return $value !== null ? mb_strtoupper($value) : null;
    }

    /** RFC en mayúsculas (estándar en México). */
    public function setRfcAttribute($value): void
    {
        $this->attributes['rfc'] = $value !== null ? mb_strtoupper((string) $value) : null;
    }

    public function getRfcAttribute($value): ?string
    {
        return $value !== null ? mb_strtoupper($value) : null;
    }

    public function movimientosCuenta()
    {
        return $this->hasMany(MovimientoCuentaCliente::class)->orderBy('fecha')->orderBy('id');
    }

    public function pagos()
    {
        return $this->hasMany(PagoCliente::class)->orderByDesc('fecha');
    }

    /** Saldo a favor de Grajalsin (lo que el cliente nos debe). Cargos - Abonos. */
    public function getSaldoCuentaAttribute(): float
    {
        $cargos = (float) $this->movimientosCuenta()->where('tipo', 'cargo')->sum('monto');
        $abonos = (float) $this->movimientosCuenta()->where('tipo', 'abono')->sum('monto');
        return round($cargos - $abonos, 2);
    }
}








