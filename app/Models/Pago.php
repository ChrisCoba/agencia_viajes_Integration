<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'reserva_id',
        'metodo_pago_id',
        'monto',
        'referencia',
        'estado_id',
        'fecha_pago'
    ];

    public $timestamps = false;
}