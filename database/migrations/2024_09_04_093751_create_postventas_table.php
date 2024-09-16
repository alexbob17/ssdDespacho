<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostventasTable extends Migration
{
    public function up()
    {
        Schema::create('postventas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('numero');
            $table->string('nombre_tecnico');
            $table->string('tipoOrden');
            $table->string('tipoactividad');
            $table->string('depto');
            $table->string('orden');
            // Campos que pueden ser nulos
            $table->text('observaciones')->nullable();
            $table->string('recibe')->nullable();
            $table->string('nodo')->nullable();
            $table->string('tap_caja')->nullable(); // Usé "tap_caja" para nombre válido en base de datos
            $table->string('posicion_puerto')->nullable(); // Usé "posicion_puerto" para nombre válido en base de datos
            $table->text('materiales')->nullable();
            $table->string('equipotv1')->nullable();
            $table->string('equipotv2')->nullable();
            $table->string('equipotv3')->nullable();
            $table->string('equipotv4')->nullable();
            $table->string('equipotv5')->nullable();
            $table->string('equipotvretira1')->nullable();
            $table->string('equipotvretira2')->nullable();
            $table->string('equipotvretira3')->nullable();
            $table->string('equipotvretira4')->nullable();
            $table->string('equipotvretira5')->nullable();
            $table->string('equipomodem')->nullable();
            $table->string('equipomodemret')->nullable();
            $table->string('coordenadas')->nullable();
            $table->string('numerocobre')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('numConsecutivo')->nullable();
            $table->timestamps();
            
            // Foreign key constraint (if user_id references a users table)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('postventas');
    }
}