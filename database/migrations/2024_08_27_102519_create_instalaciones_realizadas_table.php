<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstalacionesRealizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instalaciones_realizadas', function (Blueprint $table) {
            $table->id();  // ID primario automático
            $table->string('codigo'); // Código de instalación
            $table->string('numero'); // Número de instalación
            $table->string('nombre_tecnico'); // Nombre del técnico
            $table->string('tipoOrden'); // Tipo de orden
            $table->string('depto'); // Departamento
            $table->string('tipoactividad'); // Tipo de actividad

            // Campos que pueden ser nulos
            $table->string('ordenTv')->nullable();
            $table->string('ordenInternet')->nullable();
            $table->string('ordenLinea')->nullable();
            $table->string('equiposTvnumero1')->nullable();
            $table->string('equiposTvnumero2')->nullable();
            $table->string('equiposTvnumero3')->nullable();
            $table->string('equiposTvnumero4')->nullable();
            $table->string('equiposTvnumero5')->nullable();
            $table->string('smartcardnumero1')->nullable();
            $table->string('smartcardnumero2')->nullable();
            $table->string('smartcardnumero3')->nullable();
            $table->string('smartcardnumero4')->nullable();
            $table->string('smartcardnumero5')->nullable();
            $table->string('equipoModem')->nullable();
            $table->string('coordenadas')->nullable();
            $table->string('numeroLinea')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('recibe')->nullable();
            $table->string('nodo')->nullable();
            $table->string('tapCaja')->nullable();
            $table->string('posicion')->nullable();
            $table->string('materiales')->nullable();
            $table->string('status')->nullable();
            $table->string('numConsecutivo')->nullable();

            $table->timestamps();  // Crea columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instalaciones_realizadas');
    }
}