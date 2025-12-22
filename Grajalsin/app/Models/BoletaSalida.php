<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoletaSalida extends Model
{
    use HasFactory;

    protected $table = 'boletas_salida';

    protected $fillable = [
        'orden_carga_id',
        'folio',
        'fecha',
        'cliente_tipo',
        'cliente_nombre',
        'cliente_rfc',
        'producto',
        'variedad',
        'cosecha',
        'envase',
        'origen',
        'destino',
        'referencia',
        'operador_nombre',
        'operador_celular',
        'operador_licencia',
        'operador_curp',
        'camion',
        'placas',
        'poliza',
        'linea',
        'analisis_humedad',
        'analisis_peso_especifico',
        'analisis_impurezas',
        'analisis_quebrado',
        'analisis_danados',
        'analisis_otros',
        'peso_bruto',
        'peso_tara',
        'peso_neto',
        'peso_total',
        'observaciones',
        'notas',
        'elaboro_nombre',
        'firma_recibio_nombre',
    ];

    protected $casts = [
        'fecha' => 'date',
        'analisis_humedad' => 'decimal:2',
        'analisis_peso_especifico' => 'decimal:2',
        'analisis_impurezas' => 'decimal:2',
        'analisis_quebrado' => 'decimal:2',
        'analisis_danados' => 'decimal:2',
        'analisis_otros' => 'decimal:2',
        'peso_bruto' => 'decimal:2',
        'peso_tara' => 'decimal:2',
        'peso_neto' => 'decimal:2',
        'peso_total' => 'decimal:2',
    ];

    public function ordenCarga()
    {
        return $this->belongsTo(OrdenCarga::class);
    }

    public static function generarFolio(): string
    {
        $ultimo = self::orderByDesc('id')->first();
        $numero = $ultimo ? ((int) filter_var($ultimo->folio, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;

        return 'GRA-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }
}
