<?php

namespace App\Models\DTOs\GestionInterna;

class DetalleReservaDTO
{
    public int $idDetalle;
    public int $reservaId;
    public int $servicioId;
    public int $cantidad;
    public float $precioUnitario;
    public float $subtotal;
    public string $fechaInicio;
    public string $fechaFin;
    public string $estado;
}