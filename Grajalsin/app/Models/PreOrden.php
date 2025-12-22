<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreOrden extends Model
{
    use HasFactory;

    protected $table = 'pre_ordenes';

    protected $fillable = [
        'folio',
        'fecha',
        'chofer_id',
        'placa_tractor',
        'placa_remolque',
        'modelo',
        'linea_carga_id',
        'poliza_seguro',
        'destino_id',
        'tarifa',
        'cliente_id',
        'coordinador_nombre',
        'coordinador_telefono',
        'constancia_fiscal',
        'base_linea',
        'precio_factura',
        'notas',
    ];

    protected $casts = [
        'fecha' => 'date',
        'tarifa' => 'decimal:2',
        'precio_factura' => 'decimal:2',
    ];

    // Relaciones
    public function chofer()
    {
        return $this->belongsTo(Chofer::class)->withTrashed();
    }

    public function lineaCarga()
    {
        return $this->belongsTo(LineaCarga::class);
    }

    public function destino()
    {
        return $this->belongsTo(Destino::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pre_orden_producto')
                    ->withPivot('cantidad', 'tipo_carga', 'toneladas')
                    ->withTimestamps();
    }

    public function ordenCarga()
    {
        return $this->hasOne(OrdenCarga::class);
    }

    /**
     * Generar folio automático para la pre-orden
     */
    public static function generarFolio()
    {
        $year = date('Y');
        $ultimaPreOrden = self::whereYear('created_at', $year)
                              ->orderBy('id', 'desc')
                              ->first();
        
        if ($ultimaPreOrden && $ultimaPreOrden->folio) {
            // Extraer el número del último folio
            preg_match('/PO-' . $year . '-(\d+)/', $ultimaPreOrden->folio, $matches);
            $numero = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        } else {
            $numero = 1;
        }
        
        return 'PO-' . $year . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Boot del modelo para generar folio automáticamente
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($preOrden) {
            if (empty($preOrden->folio)) {
                $preOrden->folio = self::generarFolio();
            }
        });
    }
}

