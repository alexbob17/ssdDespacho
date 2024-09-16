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
        Schema::table('instalaciones_realizadas', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('numConsecutivo'); // Agrega la columna user_id
            
            // Si tienes una relación con la tabla users, puedes agregar una clave foránea:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('instalaciones_realizadas', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
    
};