<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id')->unsigned();
            $table->foreign('message_id')->references('id')->on('messages');
            $table->string('filename');
            $table->string('filetype');
            $table->string('filesize');
            $table->binary('binary');
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
        Schema::dropIfExists('message_files');
        Schema::enableForeignKeyConstraints();
    }
}
