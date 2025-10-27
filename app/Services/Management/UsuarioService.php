<?php

namespace App\Services\Management;

use App\Models\DTOs\GestionInterna\UsuarioDTO;
use App\Repositories\UsuarioRepository;

class UsuarioService
{
    protected UsuarioRepository $usuarioRepo;

    public function __construct(UsuarioRepository $usuarioRepo)
    {
        $this->usuarioRepo = $usuarioRepo;
    }

    public function crearUsuario(UsuarioDTO $dto): int
    {
        // Validaciones de negocio
        if (empty($dto->email)) {
            throw new \Exception("El email es obligatorio.");
        }
        return $this->usuarioRepo->guardar($dto);
    }

    public function obtenerUsuarioPorId(int $id): ?UsuarioDTO
    {
        return $this->usuarioRepo->buscarPorId($id);
    }

    public function listarUsuarios(): array
    {
        return $this->usuarioRepo->listar();
    }
}
