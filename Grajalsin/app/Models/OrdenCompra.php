<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    use HasFactory;

    protected $table = 'ordenes_compra';

    protected $fillable = [
        'tipo',
        'folio',
        'fecha',
        'proveedor_id',
        'forma_pago',
        'tipo_compra',
        'uso_cfdi',
        'subtotal',
        'iva',
        'total',
        'elaborado_por',
        'solicitado_por',
        'notas',
        'estatus',
        'user_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function lineas()
    {
        return $this->hasMany(OrdenCompraLinea::class)->orderBy('orden');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recalcularTotales(): void
    {
        // Ya no se calculan totales automáticamente
        $this->update([
            'subtotal' => 0,
            'iva' => 0,
            'total' => 0,
        ]);
    }

    public static function generarFolio(string $tipo): string
    {
        $prefijo = $tipo === 'granos' ? 'OCG' : 'OCI';
        $ultimo = static::where('folio', 'like', $prefijo . '-%')
            ->orderByDesc('id')
            ->value('folio');

        $numero = 1;
        if ($ultimo && preg_match('/' . preg_quote($prefijo) . '-(\d+)/', $ultimo, $m)) {
            $numero = (int) $m[1] + 1;
        }

        return $prefijo . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
    }
}
