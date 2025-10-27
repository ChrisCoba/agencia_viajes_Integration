<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion'
    ];

    public $timestamps = false;
}