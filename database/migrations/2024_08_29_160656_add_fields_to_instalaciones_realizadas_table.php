<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToInstalacionesRealizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instalaciones_realizadas', function (Blueprint $table) {
            $table->string('motivoObjetada')->nullable(); // Agrega la columna para el motivo
            $table->text('ObservacionesObj')->nullable(); // Agrega la columna para las observaciones
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
            $table->dropColumn('motivoObjetada');
            $table->dropColumn('ObservacionesObj');
        });
    }
}