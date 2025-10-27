<?php

namespace App\Models\DTOs\GestionInterna;

class ReservaDTO
{
    public int $id;
    public string $codigo;
    public int $usuarioId;
    public int $promocionId;
    public float $subtotal;
    public float $descuento;
    public float $impuestos;
    public float $total;
    public string $estado;
    public string $notas;
}