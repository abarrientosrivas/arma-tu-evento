<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proveedor_id')->unsigned();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->string('titulo');
            $table->string('cuerpo', 1000);
            $table->double('promedio', 8, 2)->nullable();
            $table->string('featuredImage')->default('default.jpg');
            $table->integer('maxPersonas')->nullable();
            $table->boolean('simultaneo')->default(true);
            $table->boolean('destacado')->default(false);
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
        Schema::dropIfExists('posts');
    }
}
