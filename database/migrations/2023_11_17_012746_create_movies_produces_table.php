<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesProducesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies_produces', function (Blueprint $table) {
            $table->unsignedBigInteger('producer_id');
            $table->unsignedBigInteger('movie_id');
  
            $table->foreign('producer_id')
                ->references('id')
                ->on('producers');

            $table->foreign('movie_id')
                ->references('id')
                ->on('movies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies_produces');
    }
}
