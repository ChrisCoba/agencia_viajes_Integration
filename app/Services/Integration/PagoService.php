<?php

namespace App\Services\Integration;

use App\Repositories\PagoRepository;
use Exception;
use SoapClient;

class PagoService
{
    private $soapClient;
    private $pagoRepository;

    public function __construct(PagoRepository $pagoRepository)
    {
        $this->pagoRepository = $pagoRepository;
        $this->initSoapClient();
    }

    private function initSoapClient()
    {
        $wsdlPath = public_path('wsdl/Pago.wsdl');
        $options = [
            'cache_wsdl' => WSDL_CACHE_NONE,
            'trace' => true
        ];

        try {
            $this->soapClient = new SoapClient($wsdlPath, $options);
        } catch (Exception $e) {
            throw new Exception("Error al inicializar el cliente SOAP de pagos: " . $e->getMessage());
        }
    }

    public function procesarPago(array $datosPago): array
    {
        try {
            $response = $this->soapClient->procesarPago([
                'monto' => $datosPago['monto'],
                'moneda' => $datosPago['moneda'] ?? 'PEN',
                'metodoPago' => $datosPago['metodoPago'],
                'numeroTarjeta' => $datosPago['numeroTarjeta'] ?? null,
                'fechaExpiracion' => $datosPago['fechaExpiracion'] ?? null,
                'cvv' => $datosPago['cvv'] ?? null,
                'titular' => $datosPago['titular'] ?? null,
                'email' => $datosPago['email'],
                'descripcion' => $datosPago['descripcion']
            ]);

            $pago = $this->pagoRepository->registrarPago([
                'reserva_id' => $datosPago['reserva_id'],
                'monto' => $datosPago['monto'],
                'referencia' => $response->referenciaPago,
                'estado' => $response->estado,
                'metodo_pago' => $datosPago['metodoPago']
            ]);

            return [
                'estado' => $response->estado,
                'referenciaPago' => $response->referenciaPago,
                'mensaje' => $response->mensaje,
                'pago_id' => $pago->id
            ];
        } catch (Exception $e) {
            throw new Exception("Error al procesar el pago: " . $e->getMessage());
        }
    }

    public function verificarEstadoPago(string $referenciaPago): array
    {
        try {
            $response = $this->soapClient->consultarPago([
                'referenciaPago' => $referenciaPago
            ]);

            if ($response->estado !== 'PENDIENTE') {
                $pago = $this->pagoRepository->findByReferencia($referenciaPago);
                if ($pago) {
                    $this->pagoRepository->actualizarEstado($pago->id, $response->estado);
                }
            }

            return [
                'estado' => $response->estado,
                'mensaje' => $response->mensaje,
                'fechaProcesamiento' => $response->fechaProcesamiento ?? null
            ];
        } catch (Exception $e) {
            throw new Exception("Error al verificar estado del pago: " . $e->getMessage());
        }
    }

    public function solicitarReembolso(string $referenciaPago, float $monto, string $motivo): array
    {
        try {
            $response = $this->soapClient->solicitarReembolso([
                'referenciaPago' => $referenciaPago,
                'monto' => $monto,
                'motivo' => $motivo
            ]);

            $pago = $this->pagoRepository->findByReferencia($referenciaPago);
            if ($pago) {
                $this->pagoRepository->registrarReembolso($pago->id, [
                    'monto' => $monto,
                    'motivo' => $motivo,
                    'estado' => $response->estado,
                    'referencia_reembolso' => $response->referenciaReembolso
                ]);
            }

            return [
                'estado' => $response->estado,
                'referenciaReembolso' => $response->referenciaReembolso,
                'mensaje' => $response->mensaje
            ];
        } catch (Exception $e) {
            throw new Exception("Error al solicitar reembolso: " . $e->getMessage());
        }
    }
}