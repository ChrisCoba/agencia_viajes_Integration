<?php

namespace App\Repositories;

use App\Models\Servicio;
use App\Models\DTOs\IntegracionExterna\ServicioDTO;
use Carbon\Carbon;

class ServicioRepository
{
    public function guardar(ServicioDTO $dto): int
    {
        $servicio = new Servicio();
        $servicio->codigo = $dto->codigo;
        $servicio->nombre = $dto->nombre;
        $servicio->categoria_id = $dto->categoria_id;
        $servicio->descripcion = $dto->descripcion;
        $servicio->precio_base = $dto->precio;
        $servicio->duracion_dias = $dto->duracionDias;
        $servicio->cupo_maximo = $dto->cupoMaximo;
        $servicio->estado_id = $dto->estado;
        $servicio->save();

        return $servicio->id;
    }

    public function find(int $id): ?Servicio
    {
        return Servicio::find($id);
    }

    public function verificarDisponibilidad(int $servicioId, string $fecha): bool
    {
        $servicio = $this->find($servicioId);
        if (!$servicio) {
            return false;
        }

        $fechaCarbon = Carbon::parse($fecha);
        
        // Verificar si hay cupo disponible para la fecha
        $reservasEnFecha = $servicio->reservas()
            ->whereDate('fecha_inicio', '<=', $fechaCarbon)
            ->whereDate('fecha_fin', '>=', $fechaCarbon)
            ->sum('cantidad_personas');

        return $reservasEnFecha < $servicio->cupo_maximo;
    }

    public function listarServiciosDisponibles(string $fecha, ?string $categoria = null): array
    {
        $query = Servicio::where('estado_id', 1); // Asumiendo 1 como estado activo

        if ($categoria) {
            $query->where('categoria', $categoria);
        }

        return $query->get()
            ->filter(function($servicio) use ($fecha) {
                return $this->verificarDisponibilidad($servicio->id, $fecha);
            })
            ->values()
            ->toArray();
    }
}