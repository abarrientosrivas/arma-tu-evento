<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTiposuscToProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proveedors', function (Blueprint $table) {
            // $table->enum('tipo_susc', ['Mensual', 'Trimestral', 'Anual'])->nullable();
            $table->integer('tipo_susc_id')->unsigned()->nullable();
            $table->foreign('tipo_susc_id')->references('id')->on('tipo_pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proveedors', function (Blueprint $table) {
        });
    }
}
