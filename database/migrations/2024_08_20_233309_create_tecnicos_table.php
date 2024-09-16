<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tecnicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tecnico');
            $table->string('codigo')->unique();
            $table->string('numero')->unique();
            $table->string('cedula');
            $table->enum('status', ['Activo', 'Desactivo']);
            $table->timestamps();
            $table->softDeletes(); // Para permitir la baja (eliminación lógica)
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tecnicos');
    }
};