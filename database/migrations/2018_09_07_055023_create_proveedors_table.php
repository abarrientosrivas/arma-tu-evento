<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion', 400)->nullable();
            $table->string('cuit');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('destacado_rubro')->default(false);
            $table->boolean('pago')->nullable();
            $table->date('fin_susc')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('proveedors');
        Schema::enableForeignKeyConstraints();
    }
}
