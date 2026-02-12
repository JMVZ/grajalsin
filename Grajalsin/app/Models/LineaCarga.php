<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineaCarga extends Model
{
    use HasFactory;

    protected $table = 'lineas_carga';

    protected $fillable = [
        'nombre',
        'contacto',
        'telefono',
        'base_operacion',
        'estatus',
        'notas',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];
}

