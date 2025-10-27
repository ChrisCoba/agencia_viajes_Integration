<?php

namespace App\Repositories;

use App\Models\Reserva;
use App\Models\DTOs\GestionInterna\ReservaDTO;
use App\Models\DTOs\ReservaIntegracionDTO;
use Carbon\Carbon;

class ReservaRepository
{
    public function guardar(ReservaDTO $dto): int
    {
        $reserva = new Reserva();
        $reserva->codigo = $dto->codigo;
        $reserva->usuario_id = $dto->usuarioId;
        $reserva->promocion_id = $dto->promocionId;
        $reserva->subtotal = $dto->subtotal;
        $reserva->descuento = $dto->descuento;
        $reserva->impuestos = $dto->impuestos;
        $reserva->total = $dto->total;
        $reserva->estado_id = $dto->estado;
        $reserva->notas = $dto->notas;
        $reserva->save();

        return $reserva->id;
    }

    public function buscarPorId(int $id): ?ReservaDTO
    {
        $reserva = Reserva::find($id);
        if (!$reserva) return null;

        $dto = new ReservaDTO();
        $dto->id = $reserva->id;
        $dto->codigo = $reserva->codigo;
        $dto->usuarioId = $reserva->usuario_id;
        $dto->promocionId = $reserva->promocion_id;
        $dto->subtotal = $reserva->subtotal;
        $dto->descuento = $reserva->descuento;
        $dto->impuestos = $reserva->impuestos;
        $dto->total = $reserva->total;
        $dto->estado = $reserva->estado_id;
        $dto->notas = $reserva->notas;

        return $dto;
    }

    public function findByBookingId(string $bookingId): ?Reserva
    {
        return Reserva::where('booking_id', $bookingId)->first();
    }

    public function crearReservaPorIntegracion(ReservaIntegracionDTO $dto, int $usuarioId): Reserva
    {
        $reserva = new Reserva();
        $reserva->booking_id = $dto->bookingId;
        $reserva->usuario_id = $usuarioId;
        $reserva->estado_id = $this->mapEstadoIntegracion($dto->estado);
        $reserva->save();

        return $reserva;
    }

    public function actualizarEstadoIntegracion(string $bookingId, string $estado): bool
    {
        $reserva = $this->findByBookingId($bookingId);
        if (!$reserva) {
            return false;
        }

        $reserva->estado_id = $this->mapEstadoIntegracion($estado);
        return $reserva->save();
    }

    private function mapEstadoIntegracion(string $estadoIntegracion): int
    {
        $mapeoEstados = [
            'PENDIENTE' => 1,
            'CONFIRMADA' => 2,
            'CANCELADA' => 3,
            'COMPLETADA' => 4
        ];

        return $mapeoEstados[$estadoIntegracion] ?? 1; // Por defecto estado pendiente
    }

    public function agregarDetalle(Reserva $reserva, array $detalle)
    {
        return $reserva->detalles()->create([
            'servicio_id' => $detalle['servicio_id'],
            'cantidad_personas' => $detalle['cantidad_personas'],
            'precio_unitario' => $detalle['precio_unitario'],
            'subtotal' => $detalle['precio_unitario'] * $detalle['cantidad_personas']
        ]);
    }

    public function getReservasActivas(): array
    {
        return Reserva::whereIn('estado_id', [1, 2]) // Pendiente o Confirmada
            ->with(['detalles', 'usuario'])
            ->get()
            ->toArray();
    }

    public function calcularTotal(array $detalles): float
    {
        return array_reduce($detalles, function($total, $detalle) {
            return $total + ($detalle['precio_unitario'] * $detalle['cantidad_personas']);
        }, 0.0);
    }
}