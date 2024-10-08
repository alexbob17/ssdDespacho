<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->integer('idconsulta')->unsigned()->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn('idconsulta');
        });
    }
   
};