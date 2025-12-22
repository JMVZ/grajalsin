<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCarga extends Model
{
    use HasFactory;

    protected $table = 'ordenes_carga';

    protected $fillable = [
        'pre_orden_id',
        'folio',
        'fecha_entrada',
        'origen',
        'bodega',
        'destino',
        'peso',
        'producto',
        'presentacion',
        'costal',
        'observaciones',
        'operador_nombre',
        'operador_celular',
        'operador_licencia',
        'operador_curp',
        'placas_camion',
        'descripcion',
        'linea',
        'poliza',
        'referencia',
        'elaboro_nombre',
        'elaboro_celular',
        'recibe_nombre',
        'recibe_celular',
    ];

    protected $casts = [
        'fecha_entrada' => 'date',
    ];

    public function preOrden()
    {
        return $this->belongsTo(PreOrden::class);
    }

    public function boletaSalida()
    {
        return $this->hasOne(BoletaSalida::class);
    }

    public static function generarFolio(): string
    {
        $ultimo = self::orderByDesc('id')->first();
        $numero = $ultimo ? ((int) filter_var($ultimo->folio, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
        return 'GRA-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }
}
