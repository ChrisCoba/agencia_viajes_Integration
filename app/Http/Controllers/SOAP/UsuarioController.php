<?php

namespace App\Http\Controllers\SOAP;

use App\Services\Management\UsuarioService;
use App\Models\DTOs\GestionInterna\UsuarioDTO;

class UsuarioController
{
    protected UsuarioService $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function obtenerUsuarios()
    {
        return $this->usuarioService->listarUsuarios();
    }

    public function obtenerUsuarioPorId($idUsuario)
    {
        return $this->usuarioService->obtenerUsuarioPorId($idUsuario);
    }

    public function crearUsuario($usuarioData)
    {
        $dto = new UsuarioDTO();
        foreach ($usuarioData as $key => $value) {
            $dto->$key = $value;
        }
        return $this->usuarioService->crearUsuario($dto);
    }
}