<?php

namespace App\Services\Management;

use App\Models\DTOs\GestionInterna\PagoDTO;
use App\Repositories\PagoRepository;

class PagoService
{
    protected PagoRepository $pagoRepo;

    public function __construct(PagoRepository $pagoRepo)
    {
        $this->pagoRepo = $pagoRepo;
    }

    public function registrarPago(PagoDTO $dto): int
    {
        if ($dto->monto <= 0) {
            throw new \Exception("El monto del pago debe ser mayor a cero.");
        }
        return $this->pagoRepo->guardar($dto);
    }

    public function obtenerPagoPorId(int $id): ?PagoDTO
    {
        // Aquí podrías implementar buscarPorId en el repositorio
        return null;
    }
}