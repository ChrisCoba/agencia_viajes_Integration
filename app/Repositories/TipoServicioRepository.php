<?php

namespace App\Repositories;

use App\Models\TipoServicio;
use App\Models\DTOs\GestionInterna\TipoServicioDTO;

class TipoServicioRepository
{
    public function guardar(TipoServicioDTO $dto): int
    {
        $tipo = new TipoServicio();
        $tipo->codigo = $dto->codigo;
        $tipo->nombre = $dto->nombre;
        $tipo->descripcion = $dto->descripcion;
        $tipo->save();

        return $tipo->id;
    }

    public function buscarPorId(int $id): ?TipoServicioDTO
    {
        $tipo = TipoServicio::find($id);
        if (!$tipo) return null;

        $dto = new TipoServicioDTO();
        $dto->id = $tipo->id;
        $dto->codigo = $tipo->codigo;
        $dto->nombre = $tipo->nombre;
        $dto->descripcion = $tipo->descripcion;

        return $dto;
    }
}