<?php

namespace App\Models\DTOs\IntegracionExterna;

class ReservaIntegracionDTO
{
    public string $bookingId;
    public string $estado; // CONFIRMADA, CANCELADA, etc.
}