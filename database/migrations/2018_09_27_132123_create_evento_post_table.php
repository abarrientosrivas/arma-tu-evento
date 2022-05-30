<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventoPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_post', function (Blueprint $table) {
            $table->integer('evento_id')->unsigned()->nullable();
            $table->foreign('evento_id')->references('id')->on('eventos');

            $table->integer('post_id')->unsigned()->nullable();
            $table->foreign('post_id')->references('id')->on('posts');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento_post');
    }
}
