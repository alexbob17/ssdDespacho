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
        Schema::create('reparaciones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('numero');
            $table->string('nombre_tecnico');
            $table->string('tipoOrden');
            $table->string('tipoactividad');
            $table->string('Depto');
            $table->string('orden');

            $table->string('solicitudcambio')->nullable();
            $table->string('codigocausa')->nullable();
            $table->string('tipocausa')->nullable();
            $table->string('tipodaño')->nullable();
            $table->string('ubicaciondaño')->nullable();
            $table->string('recibe')->nullable();
            $table->text('comentarios')->nullable();
            $table->string('motivoObjetada')->nullable();
            $table->text('comentariosObjetado')->nullable();
            $table->text('ObservacionesTransferida')->nullable();
            $table->text('comentariosTransferida')->nullable();
            $table->string('status');
            $table->unsignedBigInteger('user_id');
            $table->string('numConsecutivo');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reparaciones');
    }
};