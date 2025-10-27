<?php

namespace App\Services\Management;

use App\Models\DTOs\GestionInterna\ReservaDTO;
use App\Repositories\ReservaRepository;

class ReservaService
{
    protected ReservaRepository $reservaRepo;

    public function __construct(ReservaRepository $reservaRepo)
    {
        $this->reservaRepo = $reservaRepo;
    }

    public function crearReserva(ReservaDTO $dto): int
    {
        if ($dto->total <= 0) {
            throw new \Exception("El total debe ser mayor a cero.");
        }
        return $this->reservaRepo->guardar($dto);
    }

    public function obtenerReservaPorId(int $id): ?ReservaDTO
    {
        return $this->reservaRepo->buscarPorId($id);
    }

    public function cancelarReserva(int $id): bool
    {
        $reserva = $this->reservaRepo->buscarPorId($id);
        if (!$reserva) return false;

        // Aquí podrías cambiar el estado a CANCELADA
        return true;
    }
}