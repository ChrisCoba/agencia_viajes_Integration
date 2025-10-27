<?php

namespace App\Http\Controllers\SOAP;

use App\Services\Management\PagoService;
use App\Models\DTOs\GestionInterna\PagoDTO;

class PagoController
{
    protected PagoService $pagoService;

    public function __construct(PagoService $pagoService)
    {
        $this->pagoService = $pagoService;
    }

    public function crearPago($pagoData)
    {
        $dto = new PagoDTO();
        foreach ($pagoData as $key => $value) {
            $dto->$key = $value;
        }
        return $this->pagoService->registrarPago($dto);
    }
}