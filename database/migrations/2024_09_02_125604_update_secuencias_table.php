<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSecuenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('secuencias', function (Blueprint $table) {
            // Si existe una columna 'tipo', la eliminamos
            if (Schema::hasColumn('secuencias', 'tipo')) {
                $table->dropColumn('tipo');
            }

            // Asegurarse de que la columna 'valor' esté configurada correctamente
            $table->bigInteger('valor')->default(60000000)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('secuencias', function (Blueprint $table) {
            // Restaurar la columna 'tipo' si es necesario
            $table->string('tipo')->nullable();

            // Restaurar la configuración original de 'valor' si es necesario
            // Ajusta la línea de abajo según sea necesario para revertir la columna
            $table->integer('valor')->default(0)->change();
        });
    }
}