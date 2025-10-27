<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Models\DTOs\GestionInterna\UsuarioDTO;
use Carbon\Carbon;

class UsuarioRepository
{
    public function guardar(UsuarioDTO $dto): int
    {
        $usuario = new Usuario();
        $usuario->nombre = $dto->nombre;
        $usuario->apellido = $dto->apellido;
        $usuario->email = $dto->email;
        $usuario->telefono = $dto->telefono;
        $usuario->direccion = $dto->direccion;
        $usuario->ciudad = $dto->ciudad;
        $usuario->pais = $dto->pais;
        $usuario->activo = $dto->activo;
        $usuario->save();

        return $usuario->id;
    }

    public function buscarPorId(int $id): ?UsuarioDTO
    {
        $usuario = Usuario::find($id);
        if (!$usuario) return null;

        $dto = new UsuarioDTO();
        $dto->idUsuario = $usuario->id;
        $dto->nombre = $usuario->nombre;
        $dto->apellido = $usuario->apellido;
        $dto->email = $usuario->email;
        $dto->telefono = $usuario->telefono;
        $dto->direccion = $usuario->direccion;
        $dto->ciudad = $usuario->ciudad;
        $dto->pais = $usuario->pais;
        $dto->activo = $usuario->activo;

        return $dto;
    }

    public function listar(): array
    {
        return Usuario::all()->map(function ($usuario) {
            $dto = new UsuarioDTO();
            $dto->idUsuario = $usuario->id;
            $dto->nombre = $usuario->nombre;
            $dto->apellido = $usuario->apellido;
            $dto->email = $usuario->email;
            $dto->telefono = $usuario->telefono;
            $dto->direccion = $usuario->direccion;
            $dto->ciudad = $usuario->ciudad;
            $dto->pais = $usuario->pais;
            $dto->activo = $usuario->activo;
            return $dto;
        })->toArray();
    }

    public function guardarUsuarioExterno(array $datos): int
    {
        $usuario = new Usuario();
        $usuario->tipo_documento = $datos['tipo_documento'];
        $usuario->numero_documento = $datos['numero_documento'];
        $usuario->nombre = $datos['nombres'];
        $usuario->apellido = $datos['apellidos'];
        $usuario->email = $datos['email'];
        $usuario->telefono = $datos['telefono'];
        $usuario->fecha_nacimiento = $datos['fecha_nacimiento'];
        $usuario->id_externo = $datos['id_externo'];
        $usuario->origen = 'EXTERNO';
        $usuario->activo = true;
        $usuario->save();

        return $usuario->id;
    }

    public function findByIdExterno(int $idExterno): ?Usuario
    {
        return Usuario::where('id_externo', $idExterno)->first();
    }

    public function actualizarUsuario(int $id, array $datos): bool
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return false;
        }

        foreach ($datos as $campo => $valor) {
            if (in_array($campo, [
                'nombres', 'apellidos', 'email', 'telefono',
                'fecha_nacimiento', 'direccion', 'ciudad', 'pais'
            ])) {
                $usuario->$campo = $valor;
            }
        }

        return $usuario->save();
    }

    public function registrarHistorialViaje(int $idExterno, array $viaje): void
    {
        $usuario = $this->findByIdExterno($idExterno);
        if (!$usuario) {
            return;
        }

        $usuario->historialViajes()->create([
            'destino' => $viaje['destino'],
            'fecha_inicio' => $viaje['fecha_inicio'],
            'fecha_fin' => $viaje['fecha_fin'],
            'tipo_viaje' => $viaje['tipo_viaje'],
            'calificacion' => $viaje['calificacion'] ?? null,
            'comentarios' => $viaje['comentarios'] ?? null
        ]);
    }

    public function findByDocumento(string $tipoDocumento, string $numeroDocumento): ?Usuario
    {
        return Usuario::where('tipo_documento', $tipoDocumento)
            ->where('numero_documento', $numeroDocumento)
            ->first();
    }

    public function verificarDisponibilidadEmail(string $email): bool
    {
        return !Usuario::where('email', $email)->exists();
    }
}
