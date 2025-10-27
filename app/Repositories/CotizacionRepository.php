<?php

namespace App\Repositories;

use App\Models\DTOs\IntegracionExterna\CotizacionDTO;

class CotizacionRepository
{
    // Este DAO no persiste en DB, pero se incluye para consistencia
    public function crearCotizacion(array $items): CotizacionDTO
    {
        $total = array_sum(array_column($items, 'precio'));
        $breakdown = [
            'subtotal' => $total,
            'impuestos' => $total * 0.12,
            'total' => $total * 1.12
        ];

        $dto = new CotizacionDTO();
        $dto->total = $breakdown['total'];
        $dto->breakdown = $breakdown;

        return $dto;
    }
}