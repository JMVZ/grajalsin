<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perdida extends Model
{
    use HasFactory;

    protected $table = 'perdidas';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'tipo_perdida',
        'ubicacion',
        'descripcion',
        'acciones_tomadas',
        'valor_estimado',
        'evidencia_foto',
        'user_id',
        'fecha_deteccion'
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'valor_estimado' => 'decimal:2',
        'fecha_deteccion' => 'datetime',
    ];

    /**
     * Relación con producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación con usuario responsable del registro
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope para filtrar por tipo de pérdida
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_perdida', $tipo);
    }

    /**
     * Scope para un rango de fechas
     */
    public function scopeEntreFechas($query, $desde, $hasta)
    {
        return $query->whereBetween('fecha_deteccion', [$desde, $hasta]);
    }
}

