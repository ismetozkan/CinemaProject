<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_id')->constrained('cinemas');
            $table->string('title');
            $table->string('code')->nullable();
            $table->enum('removed',['Y','N'])->default('N'); //veri silinme işlemi gerçekleştirmediğimiz için silme işlemini bu kolon üzerinden yapıyoruz.
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
        Schema::dropIfExists('salons');
    }
}
