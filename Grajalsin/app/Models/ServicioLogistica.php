<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioLogistica extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicio_logisticas';

    protected $fillable = [
        'folio',
        'cliente_id',
        'tipo_unidad',
        'tipo_carga',
        'linea_carga_id',
        'tarifa',
        'comision_porcentaje',
        'comision_monto',
        'chofer_id',
        'operador_nombre',
        'operador_celular',
        'operador_licencia_numero',
        'operador_curp_rfc',
        'placa_tractor',
        'placa_remolque',
        'modelo_color',
        'poliza_compania',
        'destino_id',
        'destino_carga',
        'bodega',
        'criba',
        'cliente_empresa',
        'coordinador_nombre',
        'coordinador_numero',
        'fecha',
        'fecha_carga',
        'fecha_destino',
        'estado',
        'comision_pagada',
        'fecha_pago_comision',
        'notas_monitoreo',
        'tiene_carga_retorno',
        'servicio_retorno_id',
        'notas_retorno',
        'clave_interna',
        'notas_internas',
        'user_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_carga' => 'date',
        'fecha_destino' => 'date',
        'fecha_pago_comision' => 'date',
        'tarifa' => 'decimal:2',
        'comision_porcentaje' => 'decimal:2',
        'comision_monto' => 'decimal:2',
        'comision_pagada' => 'boolean',
        'tiene_carga_retorno' => 'boolean',
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function lineaCarga()
    {
        return $this->belongsTo(LineaCarga::class);
    }

    public function chofer()
    {
        return $this->belongsTo(Chofer::class)->withTrashed();
    }

    public function destino()
    {
        return $this->belongsTo(Destino::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function servicioRetorno()
    {
        return $this->belongsTo(ServicioLogistica::class, 'servicio_retorno_id');
    }

    public function serviciosRetorno()
    {
        return $this->hasMany(ServicioLogistica::class, 'servicio_retorno_id');
    }

    /**
     * Generar folio automático
     */
    public static function generarFolio(): string
    {
        $ultimo = self::orderByDesc('id')->first();
        $numero = $ultimo ? ((int) filter_var($ultimo->folio, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
        return 'OC-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Boot del modelo para generar folio automáticamente
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($servicio) {
            if (empty($servicio->folio)) {
                $servicio->folio = self::generarFolio();
            }
            if (empty($servicio->user_id)) {
                $servicio->user_id = auth()->id();
            }
        });
    }

    /**
     * Obtener el nombre del tipo de unidad
     */
    public function getTipoUnidadNombreAttribute(): string
    {
        return match($this->tipo_unidad) {
            'thermo' => 'Thermo',
            'caja_seca' => 'Caja Seca',
            'jaula' => 'Jaula',
            'plataforma' => 'Plataforma',
            default => $this->tipo_unidad,
        };
    }

    /**
     * Obtener el nombre del estado
     */
    public function getEstadoNombreAttribute(): string
    {
        return match($this->estado) {
            'solicitado' => 'Solicitado',
            'en_contacto' => 'En Contacto con Línea',
            'orden_preparada' => 'Orden Preparada',
            'en_transito' => 'En Tránsito',
            'en_destino' => 'En Destino',
            'comision_pagada' => 'Comisión Pagada',
            'completado' => 'Completado',
            default => $this->estado,
        };
    }
}
