<?php

namespace App\Models\DTOs\IntegracionExterna;

class ServicioDTO
{
    public string $codigo;
    public string $nombre;
    public int $categoria_id;
    public string $descripcion;
    public float $precio;
    public int $duracionDias;
    public int $cupoMaximo;
    public int $estado;

    public function __construct(
        string $codigo,
        string $nombre,
        int $categoria_id,
        string $descripcion,
        float $precio,
        int $duracionDias,
        int $cupoMaximo,
        int $estado
    ) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->categoria_id = $categoria_id;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->duracionDias = $duracionDias;
        $this->cupoMaximo = $cupoMaximo;
        $this->estado = $estado;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['codigo'],
            $data['nombre'],
            $data['categoria_id'],
            $data['descripcion'],
            $data['precio'],
            $data['duracionDias'],
            $data['cupoMaximo'],
            $data['estado']
        );
    }

    public function toArray(): array
    {
        return [
            'codigo' => $this->codigo,
            'nombre' => $this->nombre,
            'categoria_id' => $this->categoria_id,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'duracionDias' => $this->duracionDias,
            'cupoMaximo' => $this->cupoMaximo,
            'estado' => $this->estado
        ];
    }
}