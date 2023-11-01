<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('Location');
            $table->string('Destination');
            $table->string('Passengers');
            $table->string('price');
            $table->date('Date');
            $table->time('time');
            $table->string('Flight_number');
            $table->string('From');
            $table->string('company');
            $table->string('pickup_address');
            $table->string('destination_address');
            $table->string('First_Name');
            $table->string('Family_Name');
            $table->string('Countr');
            $table->string('codephone');
            $table->string('Phone');
            $table->string('Email');
            $table->string('Comments');
            $table->string('paymethode');
            $table->string('triptype');
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
        Schema::dropIfExists('reservations');
    }
}
