<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'tipo_producto',
        'codigo',
        'descripcion',
        'unidad_medida',
        'maneja_stock',
        'stock_actual',
        'stock_minimo',
        'stock_maximo',
        'precio_compra',
        'precio_venta',
        'ubicacion',
        'activo',
        'imagen'
    ];

    protected $casts = [
        'maneja_stock' => 'boolean',
        'activo' => 'boolean',
        'stock_actual' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'stock_maximo' => 'decimal:2',
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
    ];

    /**
     * Relación con movimientos
     */
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    /**
     * Relación con pérdidas
     */
    public function perdidas()
    {
        return $this->hasMany(Perdida::class);
    }

    /**
     * Verificar si el stock está bajo
     */
    public function isStockBajo()
    {
        if (!$this->maneja_stock) {
            return false; // Si no maneja stock, nunca está bajo
        }
        
        return $this->stock_minimo && $this->stock_actual <= $this->stock_minimo;
    }

    /**
     * Verificar si el stock está alto
     */
    public function isStockAlto()
    {
        if (!$this->maneja_stock) {
            return false;
        }
        
        return $this->stock_maximo && $this->stock_actual >= $this->stock_maximo;
    }

    /**
     * Obtener el estado del stock
     */
    public function getEstadoStockAttribute()
    {
        if (!$this->maneja_stock) {
            return 'sin_stock'; // Siempre disponible
        }
        
        if ($this->isStockBajo()) {
            return 'bajo';
        }
        
        if ($this->isStockAlto()) {
            return 'alto';
        }
        
        return 'normal';
    }

    /**
     * Calcular el valor total del inventario de este producto
     */
    public function getValorInventarioAttribute()
    {
        if (!$this->maneja_stock) {
            return 0;
        }
        
        return $this->stock_actual * ($this->precio_compra ?? 0);
    }

    /**
     * Scope para productos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para productos que manejan stock
     */
    public function scopeManejaStock($query)
    {
        return $query->where('maneja_stock', true);
    }

    /**
     * Scope para productos sin stock (bajo pedido)
     */
    public function scopeSinStock($query)
    {
        return $query->where('maneja_stock', false);
    }

    /**
     * Scope para productos tipo costal
     */
    public function scopeCostales($query)
    {
        return $query->where('tipo_producto', 'costal');
    }

    /**
     * Scope para productos tipo grano
     */
    public function scopeGranos($query)
    {
        return $query->where('tipo_producto', 'grano');
    }
}

