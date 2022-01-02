<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaToMovie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinema_to_movie', function (Blueprint $table) {

            $table->unsignedBigInteger('cinema_id');
            $table->unsignedBigInteger('movie_id');
            $table->foreign("cinema_id")->references("id")->on("cinemas");
            $table->foreign("movie_id")->references("id")->on("movies");
            $table->date('start'); //YYYY-MM-DD
            $table->date('end'); //YYYY-MM-DD
            $table->enum('showings',['Y','N','P'])->default('N'); //veri silinme işlemi gerçekleştirmediğimiz için silme işlemini bu kolon üzerinden yapıyoruz.
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
        Schema::dropIfExists('cinema_to_movie');
    }
}
