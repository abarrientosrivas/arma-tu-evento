<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRubroToCertificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificados', function (Blueprint $table) {
            // $table->integer('rubro_id')->unsigned()->after('id');
            // $table->foreign('rubro_id')->references('id')->on('rubros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificados', function (Blueprint $table) {
            //
        });
    }
}
