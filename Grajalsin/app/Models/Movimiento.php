<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';

    protected $fillable = [
        'producto_id',
        'tipo',
        'motivo',
        'cantidad',
        'precio_unitario',
        'total',
        'lote',
        'referencia',
        'notas',
        'ubicacion_origen',
        'ubicacion_destino',
        'user_id',
        'fecha_movimiento'
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'total' => 'decimal:2',
        'fecha_movimiento' => 'datetime',
    ];

    /**
     * Relación con producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación con usuario responsable
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Boot del modelo para actualizar stock automáticamente
     */
    protected static function booted()
    {
        static::created(function ($movimiento) {
            $producto = $movimiento->producto;
            
            // Solo actualizar stock si el producto maneja stock
            if ($producto->maneja_stock) {
                if ($movimiento->tipo === 'entrada') {
                    $producto->stock_actual += $movimiento->cantidad;
                } elseif ($movimiento->tipo === 'salida') {
                    $producto->stock_actual -= $movimiento->cantidad;
                }
                $producto->save();
            }
        });
    }

    /**
     * Scope para entradas
     */
    public function scopeEntradas($query)
    {
        return $query->where('tipo', 'entrada');
    }

    /**
     * Scope para salidas
     */
    public function scopeSalidas($query)
    {
        return $query->where('tipo', 'salida');
    }

    /**
     * Scope para un rango de fechas
     */
    public function scopeEntreFechas($query, $desde, $hasta)
    {
        return $query->whereBetween('fecha_movimiento', [$desde, $hasta]);
    }
}

