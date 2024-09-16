<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMotivoAndObservacionesToInstalacionesRealizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instalaciones_realizadas', function (Blueprint $table) {
            $table->string('motivoTransferido')->nullable(); // Cambia 'ultimo_campo' al nombre del último campo actual de la tabla
            $table->string('ObservacionesTransferido')->nullable()->after('motivoTransferido');
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
            $table->dropColumn('motivoTransferido');
            $table->dropColumn('ObservacionesTransferido');
        });
    }
}