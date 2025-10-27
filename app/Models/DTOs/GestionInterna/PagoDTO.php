<?php

namespace App\Models\DTOs\GestionInterna;

class PagoDTO
{
    public int $id;
    public int $reservaId;
    public int $metodoPagoId;
    public float $monto;
    public string $referencia;
    public string $estado;
    public string $fechaPago;
}