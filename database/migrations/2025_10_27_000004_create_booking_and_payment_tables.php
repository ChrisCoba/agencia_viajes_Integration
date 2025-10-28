<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingAndPaymentTables extends Migration
{
    public function up()
    {
        // Disponibilidad
        Schema::create('disponibilidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained('servicios');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('cupo_disponible');
            $table->decimal('precio_especial', 10, 2)->nullable();
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Tipos de Promoción
        Schema::create('tipos_promocion', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Promociones
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_promocion_id')->constrained('tipos_promocion');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('valor_descuento', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('uso_maximo')->nullable();
            $table->integer('uso_actual')->default(0);
            $table->boolean('es_interno')->default(false);
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Reservas
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->foreignId('promocion_id')->nullable()->constrained('promociones');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('impuestos', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->foreignId('estado_id')->constrained('estados');
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Detalles de Reserva
        Schema::create('reserva_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained('reservas');
            $table->foreignId('servicio_id')->constrained('servicios');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Métodos de Pago
        Schema::create('metodos_pago', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Pagos
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained('reservas');
            $table->foreignId('metodo_pago_id')->constrained('metodos_pago');
            $table->decimal('monto', 10, 2);
            $table->string('referencia', 100)->nullable();
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Facturas
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained('reservas');
            $table->string('numero', 50)->unique();
            $table->timestamp('fecha_emision');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuestos', 10, 2);
            $table->decimal('total', 10, 2);
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
        Schema::dropIfExists('pagos');
        Schema::dropIfExists('metodos_pago');
        Schema::dropIfExists('reserva_detalles');
        Schema::dropIfExists('reservas');
        Schema::dropIfExists('promociones');
        Schema::dropIfExists('tipos_promocion');
        Schema::dropIfExists('disponibilidad');
    }
}