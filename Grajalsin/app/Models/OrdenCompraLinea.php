<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompraLinea extends Model
{
    use HasFactory;

    protected $fillable = [
        'orden_compra_id',
        'producto_id',
        'descripcion',
        'cantidad',
        'unidad',
        'piezas',
        'precio_unitario',
        'importe',
        'orden',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'piezas' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'importe' => 'decimal:2',
    ];

    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompra::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($linea) {
            if ($linea->cantidad && $linea->precio_unitario) {
                $linea->importe = round($linea->cantidad * $linea->precio_unitario, 2);
            }
        });
    }
}
