<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->boolean('obligatorio')->default(true);
            // $table->date('fecha');
            // $table->integer('proveedor_id')->unsigned();
            // $table->foreign('proveedor_id')->references('id')->on('proveedors');
            // $table->integer('rubro_id')->unsigned();
            // $table->foreign('rubro_id')->references('id')->on('rubros');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('certificados');
        Schema::enableForeignKeyConstraints();
    }
}
