<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'codigo',
        'categoria_id',
        'nombre',
        'descripcion',
        'precio_base',
        'duracion_dias',
        'cupo_maximo',
        'estado_id'
    ];

    public $timestamps = false;
}