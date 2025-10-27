<?php

namespace App\Services\Management;

use App\Models\DTOs\AgenciaViajes\PackageDTO;
use App\Repositories\PaqueteRepository;

class PaqueteService
{
    protected PaqueteRepository $paqueteRepo;

    public function __construct(PaqueteRepository $paqueteRepo)
    {
        $this->paqueteRepo = $paqueteRepo;
    }

    public function crearPaquete(PackageDTO $dto): int
    {
        if ($dto->totalPrice <= 0) {
            throw new \Exception("El precio total del paquete debe ser mayor a cero.");
        }
        return $this->paqueteRepo->guardar($dto);
    }
}