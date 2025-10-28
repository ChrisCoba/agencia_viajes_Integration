<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourismTables extends Migration
{
    public function up()
    {
        // Ciudades
        Schema::create('ciudades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('pais', 100);
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Tipos de Actividad
        Schema::create('tipos_actividad', function (Blueprint $table) {
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

        // Paquetes Turísticos
        Schema::create('paquetes_turisticos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ciudad_id')->constrained('ciudades');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('duracion_horas');
            $table->integer('cupo_maximo');
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Actividades del Paquete
        Schema::create('actividades_paquete', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paquete_id')->constrained('paquetes_turisticos');
            $table->foreignId('tipo_actividad_id')->constrained('tipos_actividad');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->time('horario_inicio');
            $table->time('horario_fin');
            $table->integer('duracion_minutos');
            $table->integer('cupo');
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
        Schema::dropIfExists('actividades_paquete');
        Schema::dropIfExists('paquetes_turisticos');
        Schema::dropIfExists('tipos_actividad');
        Schema::dropIfExists('ciudades');
    }
}