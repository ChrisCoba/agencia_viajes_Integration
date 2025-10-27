<?php

namespace App\Models\DTOs\GestionInterna;

class UsuarioDTO
{
    public int $idUsuario;
    public string $nombre;
    public string $apellido;
    public string $email;
    public string $telefono;
    public string $direccion;
    public string $ciudad;
    public string $pais;
    public bool $activo;
}