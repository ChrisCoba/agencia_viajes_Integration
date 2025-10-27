<?php

namespace App\Models\DTOs;

class CotizacionDTO
{
    public float $total;
    public string $breakdown;

    public function __construct(float $total, string $breakdown)
    {
        $this->total = $total;
        $this->breakdown = $breakdown;
    }

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'breakdown' => $this->breakdown
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['total'],
            $data['breakdown']
        );
    }
}