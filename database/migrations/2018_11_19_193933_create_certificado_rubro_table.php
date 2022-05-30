<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificadoRubroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificado_rubro', function (Blueprint $table) {
            $table->integer('certificado_id')->unsigned()->nullable();
            $table->foreign('certificado_id')->references('id')->on('certificados');

            $table->integer('rubro_id')->unsigned()->nullable();
            $table->foreign('rubro_id')->references('id')->on('rubros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('certificado_rubro');
        Schema::enableForeignKeyConstraints();
    }
}
