<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableFieldsToPostventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postventas', function (Blueprint $table) {
            $table->string('motivoAnulada')->nullable();
            $table->text('ObservacionesAnuladas')->nullable();
            $table->string('motivoObjetada')->nullable();
            $table->text('ObservacionesObj')->nullable();
            $table->string('motivoTransferido')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postventas', function (Blueprint $table) {
            $table->dropColumn([
                'motivoAnulada',
                'ObservacionesAnuladas',
                'motivoObjetada',
                'ObservacionesObj',
                'motivoTransferido',
            ]);
        });
    }
}