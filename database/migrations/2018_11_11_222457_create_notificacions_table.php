<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->integer('proveedor_id')->unsigned()->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->string('title');
            $table->string('body')->nullable();
            $table->string('reference')->nullable();
            $table->boolean('read')->default(false);
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
        Schema::dropIfExists('notificacions');
    }
}
