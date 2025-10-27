<?php

namespace App\Services\Management;

use App\Models\DTOs\GestionInterna\TipoServicioDTO;
use App\Repositories\TipoServicioRepository;

class TipoServicioService
{
    protected TipoServicioRepository $tipoRepo;

    public function __construct(TipoServicioRepository $tipoRepo)
    {
        $this->tipoRepo = $tipoRepo;
    }

    public function crearTipoServicio(TipoServicioDTO $dto): int
    {
        if (empty($dto->nombre)) {
            throw new \Exception("El nombre del tipo de servicio es obligatorio.");
        }
        return $this->tipoRepo->guardar($dto);
    }

    public function obtenerTipoServicioPorId(int $id): ?TipoServicioDTO
    {
        return $this->tipoRepo->buscarPorId($id);
    }
}
