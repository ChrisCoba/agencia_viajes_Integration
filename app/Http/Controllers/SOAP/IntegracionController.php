<?php

namespace App\Http\Controllers\SOAP;

use App\Http\Controllers\Controller;
use App\Services\Integration\CotizacionService;
use App\Services\Integration\PreReservaService;
use App\Services\Integration\ConfirmacionReservaService;

class IntegracionController extends Controller
{
    protected CotizacionService $cotizacionService;
    protected PreReservaService $preReservaService;
    protected ConfirmacionReservaService $confirmacionService;

    public function __construct(
        CotizacionService $cotizacionService,
        PreReservaService $preReservaService,
        ConfirmacionReservaService $confirmacionService
    ) {
        $this->cotizacionService = $cotizacionService;
        $this->preReservaService = $preReservaService;
        $this->confirmacionService = $confirmacionService;
    }

    public function cotizarReserva($items)
    {
        return $this->cotizacionService->cotizarReserva($items);
    }

    public function crearPreReserva($itinerario, $cliente, $holdMinutes)
    {
        return $this->preReservaService->crearPreReserva($itinerario, $cliente, $holdMinutes);
    }

    public function confirmarReserva($preBookingId, $metodoPago, $datosPago)
    {
        return $this->confirmacionService->confirmarReserva($preBookingId, $metodoPago, $datosPago);
    }
}