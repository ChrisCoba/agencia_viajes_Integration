<?php

namespace App\Models\DTOs;

class ReservaIntegracionDTO
{
    public string $bookingId;
    public string $estado;

    public function __construct(string $bookingId, string $estado)
    {
        $this->bookingId = $bookingId;
        $this->estado = $estado;
    }

    public function toArray(): array
    {
        return [
            'bookingId' => $this->bookingId,
            'estado' => $this->estado
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['bookingId'],
            $data['estado']
        );
    }
}