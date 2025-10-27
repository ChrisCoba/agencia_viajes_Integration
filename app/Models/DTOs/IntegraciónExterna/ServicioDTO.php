<?php

namespace App\Models\DTOs\IntegracionExterna;

class ServicioDTO
{
    public int $idServicio;
    public string $serviceType;
    public string $ciudad;
    public string $nombre;
    public string $descripcion;
    public float $precio;
    public string $amenities; // Lista serializada o JSON
    public string $clasificacion;
    public string $politicas;
    public array $imagenes; // URLs
}