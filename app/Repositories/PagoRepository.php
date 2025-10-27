<?php

namespace App\Repositories;

use App\Models\Pago;
use App\Models\DTOs\GestionInterna\PagoDTO;
use Carbon\Carbon;

class PagoRepository
{
    public function guardar(PagoDTO $dto): int
    {
        $pago = new Pago();
        $pago->reserva_id = $dto->reservaId;
        $pago->metodo_pago_id = $dto->metodoPagoId;
        $pago->monto = $dto->monto;
        $pago->referencia = $dto->referencia;
        $pago->estado_id = $dto->estado;
        $pago->fecha_pago = $dto->fechaPago;
        $pago->save();

        return $pago->id;
    }

    public function registrarPago(array $datos): Pago
    {
        $pago = new Pago();
        $pago->reserva_id = $datos['reserva_id'];
        $pago->monto = $datos['monto'];
        $pago->referencia = $datos['referencia'];
        $pago->estado_id = $this->mapEstadoPago($datos['estado']);
        $pago->metodo_pago_id = $this->getMetodoPagoId($datos['metodo_pago']);
        $pago->fecha_pago = Carbon::now();
        $pago->save();

        return $pago;
    }

    public function findByReferencia(string $referencia): ?Pago
    {
        return Pago::where('referencia', $referencia)->first();
    }

    public function actualizarEstado(int $pagoId, string $estado): bool
    {
        $pago = Pago::find($pagoId);
        if (!$pago) {
            return false;
        }

        $pago->estado_id = $this->mapEstadoPago($estado);
        $pago->fecha_actualizacion = Carbon::now();
        return $pago->save();
    }

    public function registrarReembolso(int $pagoId, array $datos): bool
    {
        $pago = Pago::find($pagoId);
        if (!$pago) {
            return false;
        }

        $pago->estado_id = $this->mapEstadoPago($datos['estado']);
        $pago->monto_reembolso = $datos['monto'];
        $pago->motivo_reembolso = $datos['motivo'];
        $pago->referencia_reembolso = $datos['referencia_reembolso'];
        $pago->fecha_reembolso = Carbon::now();
        return $pago->save();
    }

    private function mapEstadoPago(string $estadoIntegracion): int
    {
        $mapeoEstados = [
            'PENDIENTE' => 1,
            'COMPLETADO' => 2,
            'RECHAZADO' => 3,
            'REEMBOLSADO' => 4
        ];

        return $mapeoEstados[$estadoIntegracion] ?? 1; // Por defecto estado pendiente
    }

    private function getMetodoPagoId(string $metodoPago): int
    {
        $mapeoMetodos = [
            'TARJETA' => 1,
            'TRANSFERENCIA' => 2,
            'EFECTIVO' => 3,
            'YAPE' => 4,
            'PLIN' => 5
        ];

        return $mapeoMetodos[$metodoPago] ?? 1; // Por defecto tarjeta
    }

    public function listarPagosPorReserva(int $reservaId): array
    {
        return Pago::where('reserva_id', $reservaId)
            ->orderBy('fecha_pago', 'desc')
            ->get()
            ->toArray();
    }

    public function obtenerTotalPagado(int $reservaId): float
    {
        return Pago::where('reserva_id', $reservaId)
            ->where('estado_id', 2) // Estado COMPLETADO
            ->sum('monto');
    }

    public function obtenerTotalReembolsado(int $reservaId): float
    {
        return Pago::where('reserva_id', $reservaId)
            ->whereNotNull('monto_reembolso')
            ->sum('monto_reembolso');
    }
}