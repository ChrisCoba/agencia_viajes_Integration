<?php

namespace App\Services\Management;

use App\Models\DTOs\GestionInterna\ImagenServicioDTO;
use App\Repositories\ImagenServicioRepository;

class ImagenServicioService
{
    protected ImagenServicioRepository $imagenRepo;

    public function __construct(ImagenServicioRepository $imagenRepo)
    {
        $this->imagenRepo = $imagenRepo;
    }

    public function agregarImagen(ImagenServicioDTO $dto): int
    {
        if (empty($dto->url)) {
            throw new \Exception("La URL de la imagen es obligatoria.");
        }
        return $this->imagenRepo->guardar($dto);
    }
}