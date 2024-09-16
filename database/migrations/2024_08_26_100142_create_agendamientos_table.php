<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('agendamientos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('numero');
            $table->string('nombre_tecnico');
            $table->enum('tipo_agendamiento', ['Instalaciones', 'Postventas', 'Reparaciones']); // Puedes ajustar los tipos según tus necesidades
            $table->date('fecha_agendamiento');
            $table->time('hora_agendamiento');
            $table->string('numero_orden');
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('usuario_id'); // ID del usuario que registra el agendamiento
            $table->string('numeroid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

     
    public function down()
    {
        Schema::dropIfExists('agendamientos');
    }
};