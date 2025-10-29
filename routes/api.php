<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SOAP\IntegracionController;

Route::prefix('api/v1/integracion')->group(function () {
    // Rutas de Cotización
    Route::post('/cotizar', [IntegracionController::class, 'cotizarReserva']);
    
    // Rutas de Pre-reserva
    Route::post('/pre-reserva', [IntegracionController::class, 'crearPreReserva']);
    
    // Rutas de Confirmación
    Route::post('/confirmar', [IntegracionController::class, 'confirmarReserva']);
});