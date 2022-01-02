<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('showing_id')->constrained('showings');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('seat_id');
            $table->text('detail');
            $table->integer('price');
            $table->enum('type',['online','offline']);
            $table->enum('payment_status',['P','Y','N'])->default('P');
            $table->enum('payment_method',['online','cash']);
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
        Schema::dropIfExists('tickets');
    }
}
