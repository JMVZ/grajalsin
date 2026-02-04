<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'clave',
        'ubicacion',
        'estatus',
        'notas',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];
}

