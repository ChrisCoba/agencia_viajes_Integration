<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaqueteTuristico extends Model
{
    protected $table = 'paquetes_turisticos';

    protected $fillable = [
        'ciudad_id',
        'nombre',
        'descripcion',
        'precio',
        'duracion_horas',
        'cupo_maximo',
        'estado_id'
    ];

    public $timestamps = false;
}