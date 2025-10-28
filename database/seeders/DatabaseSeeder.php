<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Desactivar revisión de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Limpiar tablas existentes
        $tables = [
            'estados', 'roles', 'usuarios', 'usuario_roles', 'usuario_detalles',
            'categorias', 'ciudades', 'tipos_actividad', 'servicios', 'servicio_detalles',
            'servicio_imagenes'
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        // ESTADOS
        $estados = [
            ['id' => 1, 'tipo' => 'servicio', 'codigo' => 'ACTIVO', 'nombre' => 'Servicio disponible para la venta', 'descripcion' => 'Servicio disponible para la venta', 'activo' => true, 'created_by' => 1],
            ['id' => 2, 'tipo' => 'servicio', 'codigo' => 'INACTIVO', 'nombre' => 'Servicio no disponible', 'descripcion' => 'Servicio no disponible', 'activo' => true, 'created_by' => 1],
            ['id' => 3, 'tipo' => 'reserva', 'codigo' => 'PENDIENTE', 'nombre' => 'Reserva pendiente', 'descripcion' => 'Reserva registrada, pendiente de pago o confirmación', 'activo' => true, 'created_by' => 1],
            ['id' => 4, 'tipo' => 'reserva', 'codigo' => 'CONFIRMADA', 'nombre' => 'Reserva confirmada', 'descripcion' => 'Reserva confirmada', 'activo' => true, 'created_by' => 1],
            ['id' => 5, 'tipo' => 'reserva', 'codigo' => 'CANCELADA', 'nombre' => 'Reserva cancelada', 'descripcion' => 'Reserva cancelada', 'activo' => true, 'created_by' => 1],
            ['id' => 6, 'tipo' => 'pago', 'codigo' => 'PENDIENTE', 'nombre' => 'Pago pendiente', 'descripcion' => 'Pago creado pero no acreditado', 'activo' => true, 'created_by' => 1],
            ['id' => 7, 'tipo' => 'pago', 'codigo' => 'APROBADO', 'nombre' => 'Pago aprobado', 'descripcion' => 'Pago acreditado', 'activo' => true, 'created_by' => 1],
            ['id' => 8, 'tipo' => 'pago', 'codigo' => 'RECHAZADO', 'nombre' => 'Pago rechazado', 'descripcion' => 'Pago rechazado', 'activo' => true, 'created_by' => 1]
        ];
        DB::table('estados')->insert($estados);

        // ROLES
        $roles = [
            ['id' => 1, 'codigo' => 'ADMIN', 'nombre' => 'Admin', 'descripcion' => 'Administrador del sistema', 'created_by' => 1],
            ['id' => 2, 'codigo' => 'CLIENTE', 'nombre' => 'Cliente', 'descripcion' => 'Cliente final', 'created_by' => 1],
            ['id' => 3, 'codigo' => 'AGENTE', 'nombre' => 'Agente', 'descripcion' => 'Agente de viajes', 'created_by' => 1]
        ];
        DB::table('roles')->insert($roles);

        // USUARIOS
        $usuarios = [
            ['id' => 1, 'nombre' => 'Admin', 'apellido' => 'Sistema', 'email' => 'admin@sistema.local', 'password' => Hash::make('admin123'), 'es_interno' => true, 'activo' => true, 'created_by' => 1],
            ['id' => 2, 'nombre' => 'Ana', 'apellido' => 'García', 'email' => 'ana.garcia@example.com', 'password' => Hash::make('cliente123'), 'es_interno' => false, 'activo' => true, 'created_by' => 1],
            ['id' => 3, 'nombre' => 'Luis', 'apellido' => 'Fernández', 'email' => 'luis.fernandez@example.com', 'password' => Hash::make('agente123'), 'es_interno' => false, 'activo' => true, 'created_by' => 1]
        ];
        DB::table('usuarios')->insert($usuarios);

        // USUARIO_ROLES
        $usuarioRoles = [
            ['id' => 1, 'usuario_id' => 1, 'rol_id' => 1, 'created_by' => 1],
            ['id' => 2, 'usuario_id' => 2, 'rol_id' => 2, 'created_by' => 1],
            ['id' => 3, 'usuario_id' => 3, 'rol_id' => 3, 'created_by' => 1]
        ];
        DB::table('usuario_roles')->insert($usuarioRoles);

        // USUARIO_DETALLES
        $usuarioDetalles = [
            ['usuario_id' => 1, 'telefono' => '+34 600 000 000', 'direccion' => 'C/ Gran Vía 1', 'ciudad' => 'Madrid', 'pais' => 'España', 'created_by' => 1],
            ['usuario_id' => 2, 'telefono' => '+34 600 111 222', 'direccion' => 'C/ Alcalá 123', 'ciudad' => 'Madrid', 'pais' => 'España', 'created_by' => 1],
            ['usuario_id' => 3, 'telefono' => '+34 600 333 444', 'direccion' => 'Paseo del Prado 5', 'ciudad' => 'Madrid', 'pais' => 'España', 'created_by' => 1]
        ];
        DB::table('usuario_detalles')->insert($usuarioDetalles);

        // Reactivar revisión de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
