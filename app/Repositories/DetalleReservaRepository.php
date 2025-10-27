<?php

namespace App\Repositories;

use App\Models\ReservaDetalle;
use App\Models\DTOs\GestionInterna\DetalleReservaDTO;

class DetalleReservaRepository
{
    public function guardar(DetalleReservaDTO $dto): int
    {
        $detalle = new ReservaDetalle();
        $detalle->reserva_id = $dto->reservaId;
        $detalle->servicio_id = $dto->servicioId;
        $detalle->cantidad = $dto->cantidad;
        $detalle->precio_unitario = $dto->precioUnitario;
        $detalle->subtotal = $dto->subtotal;
        $detalle->fecha_inicio = $dto->fechaInicio;
        $detalle->fecha_fin = $dto->fechaFin;
        $detalle->estado_id = $dto->estado;
        $detalle->save();

        return $detalle->id;
    }
}