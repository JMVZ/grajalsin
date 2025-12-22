<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chofer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'choferes';

    protected $fillable = [
        'nombre',
        'telefono',
        'curp',
        'licencia_numero',
        'licencia_tipo',
        'licencia_vence',
        'expediente_medico_numero',
        'expediente_medico_vence',
        'estatus',
        'notas',
    ];

    protected $casts = [
        'licencia_vence' => 'date',
        'expediente_medico_vence' => 'date',
        'estatus' => 'boolean',
    ];
}

