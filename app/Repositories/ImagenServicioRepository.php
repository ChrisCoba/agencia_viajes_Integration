<?php

namespace App\Repositories;

use App\Models\ImagenServicio;
use App\Models\DTOs\GestionInterna\ImagenServicioDTO;

class ImagenServicioRepository
{
    public function guardar(ImagenServicioDTO $dto): int
    {
        $imagen = new ImagenServicio();
        $imagen->id_servicio = $dto->idServicio;
        $imagen->url = $dto->url;
        $imagen->tipo = $dto->tipo;
        $imagen->descripcion = $dto->descripcion;
        $imagen->orden = $dto->orden;
        $imagen->activo = $dto->activo;
        $imagen->save();

        return $imagen->id;
    }
}