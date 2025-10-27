<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservaDetalle extends Model
{
    protected $table = 'reserva_detalles';

    protected $fillable = [
        'reserva_id',
        'servicio_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'fecha_inicio',
        'fecha_fin',
        'estado_id'
    ];

    public $timestamps = false;
}