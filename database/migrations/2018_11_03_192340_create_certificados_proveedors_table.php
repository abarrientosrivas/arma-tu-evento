<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificadosProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificado_proveedors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proveedor_id')->unsigned();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->integer('certificado_id')->unsigned();
            $table->foreign('certificado_id')->references('id')->on('certificados');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificado_proveedors');
    }
}
