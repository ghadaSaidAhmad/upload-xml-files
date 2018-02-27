<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('myfile_id')->unsigned();
            $table->foreign('myfile_id')->references('id')->on('my_files')->onDelete('cascade');
            $table->string('name');
            $table->string('job');
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
        Schema::dropIfExists('my_rows');
    }
}
