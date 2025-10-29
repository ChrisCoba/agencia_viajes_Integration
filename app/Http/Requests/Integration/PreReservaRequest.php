<?php

namespace App\Http\Requests\Integration;

use Illuminate\Foundation\Http\FormRequest;

class PreReservaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'itinerario' => 'required|array',
            'itinerario.*.servicio_id' => 'required|exists:servicios,id',
            'itinerario.*.cantidad' => 'required|integer|min:1',
            'itinerario.*.fecha_inicio' => 'required|date|after:today',
            'itinerario.*.fecha_fin' => 'required|date|after:fecha_inicio',
            'cliente' => 'required|array',
            'cliente.nombre' => 'required|string|max:100',
            'cliente.apellido' => 'required|string|max:100',
            'cliente.email' => 'required|email',
            'cliente.telefono' => 'required|string|max:20',
            'holdMinutes' => 'required|integer|min:30|max:1440'
        ];
    }
}