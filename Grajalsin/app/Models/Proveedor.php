<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'rfc',
        'contacto',
        'celular',
        'telefono',
        'email',
        'direccion',
        'notas',
        'estatus',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];

    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('estatus', true);
    }
}
