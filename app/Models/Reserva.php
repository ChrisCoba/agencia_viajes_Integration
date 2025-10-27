<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'codigo',
        'usuario_id',
        'promocion_id',
        'subtotal',
        'descuento',
        'impuestos',
        'total',
        'estado_id',
        'notas'
    ];

    public $timestamps = false;

    public function detalles()
    {
        return $this->hasMany(ReservaDetalle::class, 'reserva_id');
    }
}