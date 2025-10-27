<?php

namespace App\Models\DTOs\IntegracionExterna;

class CotizacionDTO
{
    public float $total;
    public array $breakdown; // Detalle de impuestos, fees, etc.
}