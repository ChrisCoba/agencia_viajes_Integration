<?php

namespace App\Models\DTOs;

class PreReservaDTO
{
    public string $preBookingId;
    public string $expiraEn;

    public function __construct(string $preBookingId, string $expiraEn)
    {
        $this->preBookingId = $preBookingId;
        $this->expiraEn = $expiraEn;
    }

    public function toArray(): array
    {
        return [
            'preBookingId' => $this->preBookingId,
            'expiraEn' => $this->expiraEn
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['preBookingId'],
            $data['expiraEn']
        );
    }
}