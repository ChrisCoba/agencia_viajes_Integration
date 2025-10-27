<?php

namespace App\Models\DTOs\GestionInterna;

class ImagenServicioDTO
{
    public int $idImagen;
    public int $idServicio;
    public string $url;
    public string $tipo;
    public string $descripcion;
    public int $orden;
    public bool $activo;
}