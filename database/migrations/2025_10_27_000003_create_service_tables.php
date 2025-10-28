<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTables extends Migration
{
    public function up()
    {
        // Categorías
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categorias');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->integer('nivel');
            $table->integer('orden')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Servicios
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->decimal('precio_base', 10, 2);
            $table->integer('duracion_dias')->nullable();
            $table->integer('cupo_maximo')->nullable();
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        // Servicio Detalles
        Schema::create('servicio_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained('servicios');
            $table->string('ubicacion', 200)->nullable();
            $table->text('politica_cancelacion')->nullable();
            $table->text('requisitos')->nullable();
            $table->text('incluye')->nullable();
            $table->text('no_incluye')->nullable();
            $table->text('notas_importantes')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
        });

        // Servicio Imágenes
        Schema::create('servicio_imagenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained('servicios');
            $table->string('url', 500);
            $table->string('tipo', 50);
            $table->string('descripcion', 200)->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servicio_imagenes');
        Schema::dropIfExists('servicio_detalles');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('categorias');
    }
}