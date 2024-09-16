<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMotivoAnuladaAndObservacionesAnuladasToInstalacionesRealizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instalaciones_realizadas', function (Blueprint $table) {
            $table->string('motivoAnulada')->nullable(); // Reemplaza 'column_name' con la columna existente después de la cual quieres agregar este campo
            $table->text('ObservacionesAnuladas')->nullable()->after('motivoAnulada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instalaciones_realizadas', function (Blueprint $table) {
            $table->dropColumn('motivoAnulada');
            $table->dropColumn('ObservacionesAnuladas');
        });
    }
}