<?php

namespace App\Services\Integration;

use App\Repositories\UsuarioRepository;
use Exception;
use SoapClient;

class UsuarioService
{
    private $soapClient;
    private $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->initSoapClient();
    }

    private function initSoapClient()
    {
        $wsdlPath = public_path('wsdl/Usuario.wsdl');
        $options = [
            'cache_wsdl' => WSDL_CACHE_NONE,
            'trace' => true
        ];

        try {
            $this->soapClient = new SoapClient($wsdlPath, $options);
        } catch (Exception $e) {
            throw new Exception("Error al inicializar el cliente SOAP de usuarios: " . $e->getMessage());
        }
    }

    public function verificarUsuario(string $documento, string $tipoDocumento = 'DNI'): array
    {
        try {
            $response = $this->soapClient->verificarUsuario([
                'numeroDocumento' => $documento,
                'tipoDocumento' => $tipoDocumento
            ]);

            return [
                'existe' => $response->existe,
                'datos' => $response->existe ? (array)$response->datos : null
            ];
        } catch (Exception $e) {
            throw new Exception("Error al verificar usuario: " . $e->getMessage());
        }
    }

    public function registrarUsuarioExterno(array $datos): array
    {
        try {
            $response = $this->soapClient->registrarUsuario([
                'tipoDocumento' => $datos['tipo_documento'],
                'numeroDocumento' => $datos['numero_documento'],
                'nombres' => $datos['nombres'],
                'apellidos' => $datos['apellidos'],
                'email' => $datos['email'],
                'telefono' => $datos['telefono'],
                'fechaNacimiento' => $datos['fecha_nacimiento']
            ]);

            if ($response->exito) {
                // Registrar en base de datos local
                $usuarioId = $this->usuarioRepository->guardarUsuarioExterno([
                    'tipo_documento' => $datos['tipo_documento'],
                    'numero_documento' => $datos['numero_documento'],
                    'nombres' => $datos['nombres'],
                    'apellidos' => $datos['apellidos'],
                    'email' => $datos['email'],
                    'telefono' => $datos['telefono'],
                    'fecha_nacimiento' => $datos['fecha_nacimiento'],
                    'id_externo' => $response->usuarioId
                ]);

                return [
                    'exito' => true,
                    'usuario_id' => $usuarioId,
                    'id_externo' => $response->usuarioId,
                    'mensaje' => $response->mensaje
                ];
            }

            return [
                'exito' => false,
                'mensaje' => $response->mensaje
            ];
        } catch (Exception $e) {
            throw new Exception("Error al registrar usuario externo: " . $e->getMessage());
        }
    }

    public function actualizarUsuarioExterno(int $idExterno, array $datos): array
    {
        try {
            $response = $this->soapClient->actualizarUsuario(array_merge(
                ['usuarioId' => $idExterno],
                $datos
            ));

            if ($response->exito) {
                // Actualizar en base de datos local
                $usuario = $this->usuarioRepository->findByIdExterno($idExterno);
                if ($usuario) {
                    $this->usuarioRepository->actualizarUsuario($usuario->id, $datos);
                }
            }

            return [
                'exito' => $response->exito,
                'mensaje' => $response->mensaje
            ];
        } catch (Exception $e) {
            throw new Exception("Error al actualizar usuario externo: " . $e->getMessage());
        }
    }

    public function verificarPreferenciasViaje(int $idExterno): array
    {
        try {
            $response = $this->soapClient->obtenerPreferenciasViaje([
                'usuarioId' => $idExterno
            ]);

            return [
                'preferencias' => (array)$response->preferencias,
                'ultimosDestinos' => (array)$response->ultimosDestinos,
                'tipoViajeroPreferido' => $response->tipoViajero
            ];
        } catch (Exception $e) {
            throw new Exception("Error al obtener preferencias de viaje: " . $e->getMessage());
        }
    }

    public function sincronizarHistorialViajes(int $idExterno): void
    {
        try {
            $response = $this->soapClient->obtenerHistorialViajes([
                'usuarioId' => $idExterno
            ]);

            foreach ($response->viajes as $viaje) {
                $this->usuarioRepository->registrarHistorialViaje($idExterno, (array)$viaje);
            }
        } catch (Exception $e) {
            throw new Exception("Error al sincronizar historial de viajes: " . $e->getMessage());
        }
    }
}