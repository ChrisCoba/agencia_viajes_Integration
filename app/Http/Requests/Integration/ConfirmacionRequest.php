<?php

namespace App\Http\Requests\Integration;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'preBookingId' => 'required|string|exists:reservas,codigo',
            'metodoPago' => 'required|string|exists:metodos_pago,codigo',
            'datosPago' => 'required|array',
            'datosPago.monto' => 'required|numeric|min:0',
            'datosPago.referencia' => 'required|string|max:100'
        ];
    }
}