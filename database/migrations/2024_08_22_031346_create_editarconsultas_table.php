<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditarconsultasTable extends Migration
{
    public function up()
    {
        Schema::create('editarconsultas', function (Blueprint $table) {
            $table->id();
            $table->string('MotivoConsulta', 70); // Campo de texto con un máximo de 70 caracteres
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('editarconsultas');
    }
}