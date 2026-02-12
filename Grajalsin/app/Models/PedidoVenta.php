<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoVenta extends Model
{
    use HasFactory;

    protected $table = 'pedidos_venta';

    protected $fillable = [
        'folio',
        'fecha',
        'cliente_id',
        'toneladas',
        'precio_venta',
        'tarifa_flete',
        'bodega_id',
        'destino_id',
        'producto_id',
        'fecha_entrega',
        'estatus',
        'forma_pago',
        'notas',
        'user_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_entrega' => 'date',
        'toneladas' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'tarifa_flete' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function bodega()
    {
        return $this->belongsTo(Bodega::class);
    }

    public function destino()
    {
        return $this->belongsTo(Destino::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImporteSubtotalAttribute(): float
    {
        return (float) ($this->toneladas * $this->precio_venta);
    }

    /**
     * Total a pagar a Grajalsin (solo producto).
     * La tarifa de flete se paga directo a la línea de transporte; no se suma al total.
     */
    public function getImporteTotalAttribute(): float
    {
        return (float) $this->importe_subtotal;
    }

    public static function generarFolio(): string
    {
        $ultimo = static::where('folio', 'like', 'PV-%')
            ->orderByDesc('id')
            ->value('folio');

        $numero = 1;
        if ($ultimo && preg_match('/PV-(\d+)/', $ultimo, $m)) {
            $numero = (int) $m[1] + 1;
        }

        return 'PV-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }
}
