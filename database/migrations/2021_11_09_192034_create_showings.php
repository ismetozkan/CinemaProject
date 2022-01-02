<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('showings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('salon_id');
            $table->dateTime('show_date'); //Y-M-D H:M:S
            $table->enum('removed',['Y','N'])->default('N'); //veri silinme işlemi gerçekleştirmediğimiz için silme işlemini bu kolon üzerinden yapıyoruz.
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreign('salon_id')->references('id')->on('salons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('showings');
    }
}
