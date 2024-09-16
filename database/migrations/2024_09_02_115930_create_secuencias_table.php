<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecuenciasTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secuencias', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->unique(); // 'instalaciones_realizadas' o 'reparaciones'
            $table->bigInteger('valor')->default(60000000); // Valor inicial
            $table->timestamps(); // Agregar timestamps si lo necesitas
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secuencias');
    }
}