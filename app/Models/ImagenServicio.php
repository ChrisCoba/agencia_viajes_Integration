<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenServicio extends Model
{
    protected $table = 'servicio_imagenes';

    protected $fillable = [
        'servicio_id',
        'url',
        'tipo',
        'descripcion',
        'orden',
        'activo'
    ];

    public $timestamps = false;
}