<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'rfc',
        'contacto',
        'telefono',
        'email',
        'direccion',
        'estatus',
        'notas',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];
}








