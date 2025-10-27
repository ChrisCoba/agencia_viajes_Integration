<?php

namespace App\Http\Controllers\SOAP;

use App\Services\Management\ReservaService;
use App\Models\DTOs\GestionInterna\ReservaDTO;

class ReservaController
{
    protected ReservaService $reservaService;

    public function __construct(ReservaService $reservaService)
    {
        $this->reservaService = $reservaService;
    }

    public function obtenerReservas()
    {
        // Implementar método listar en el Service si lo necesitas
    }

    public function obtenerReservaPorId($id)
    {
        return $this->reservaService->obtenerReservaPorId($id);
    }

    public function crearReserva($reservaData)
    {
        $dto = new ReservaDTO();
        foreach ($reservaData as $key => $value) {
            $dto->$key = $value;
        }
        return $this->reservaService->crearReserva($dto);
    }

    public function cancelarReserva($id)
    {
        return $this->reservaService->cancelarReserva($id);
    }
}