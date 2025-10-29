<?php

namespace App\Http\Requests\Integration;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'items' => 'required|array',
            'items.*.servicio_id' => 'required|exists:servicios,id',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.fecha_inicio' => 'required|date|after:today',
            'items.*.fecha_fin' => 'required|date|after:fecha_inicio'
        ];
    }
}