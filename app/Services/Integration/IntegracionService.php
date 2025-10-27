<?php

namespace App\Services\Integration;

use App\Models\DTOs\CotizacionDTO;
use App\Models\DTOs\PreReservaDTO;
use App\Models\DTOs\ReservaIntegracionDTO;
use App\Repositories\ServicioRepository;
use App\Repositories\ReservaRepository;
use Exception;
use SoapClient;

class IntegracionService
{
    private $soapClient;
    private $servicioRepository;
    private $reservaRepository;

    public function __construct(
        ServicioRepository $servicioRepository,
        ReservaRepository $reservaRepository
    ) {
        $this->servicioRepository = $servicioRepository;
        $this->reservaRepository = $reservaRepository;
        $this->initSoapClient();
    }

    private function initSoapClient()
    {
        $wsdlPath = public_path('wsdl/Integracion.wsdl');
        $options = [
            'cache_wsdl' => WSDL_CACHE_NONE,
            'trace' => true
        ];

        try {
            $this->soapClient = new SoapClient($wsdlPath, $options);
        } catch (Exception $e) {
            throw new Exception("Error al inicializar el cliente SOAP: " . $e->getMessage());
        }
    }

    public function cotizarReserva(array $items): CotizacionDTO
    {
        try {
            $response = $this->soapClient->cotizarReserva([
                'items' => json_encode($items)
            ]);

            return CotizacionDTO::fromArray((array)$response->cotizacion);
        } catch (Exception $e) {
            throw new Exception("Error al cotizar reserva: " . $e->getMessage());
        }
    }

    public function crearPreReserva(array $itinerario, array $cliente, int $holdMinutes = 30): PreReservaDTO
    {
        try {
            $response = $this->soapClient->crearPreReserva([
                'itinerario' => json_encode($itinerario),
                'cliente' => json_encode($cliente),
                'holdMinutes' => $holdMinutes
            ]);

            return PreReservaDTO::fromArray((array)$response->preReserva);
        } catch (Exception $e) {
            throw new Exception("Error al crear pre-reserva: " . $e->getMessage());
        }
    }

    public function confirmarReserva(string $preBookingId, string $metodoPago, array $datosPago): ReservaIntegracionDTO
    {
        try {
            $response = $this->soapClient->confirmarReserva([
                'preBookingId' => $preBookingId,
                'metodoPago' => $metodoPago,
                'datosPago' => json_encode($datosPago)
            ]);

            return ReservaIntegracionDTO::fromArray((array)$response->reserva);
        } catch (Exception $e) {
            throw new Exception("Error al confirmar reserva: " . $e->getMessage());
        }
    }

    public function verificarDisponibilidad(array $servicios, string $fecha): bool
    {
        // Implementar lógica de verificación de disponibilidad
        foreach ($servicios as $servicioId) {
            $servicio = $this->servicioRepository->find($servicioId);
            if (!$servicio || !$servicio->estaDisponible($fecha)) {
                return false;
            }
        }
        return true;
    }

    public function sincronizarEstadoReserva(string $bookingId)
    {
        try {
            // Implementar lógica de sincronización de estado
            $reserva = $this->reservaRepository->findByBookingId($bookingId);
            if (!$reserva) {
                throw new Exception("Reserva no encontrada");
            }

            // Aquí iría la lógica de consulta al servicio externo
            // y actualización del estado en la base de datos local

            return true;
        } catch (Exception $e) {
            throw new Exception("Error al sincronizar estado de reserva: " . $e->getMessage());
        }
    }
}