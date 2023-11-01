<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetreatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retreats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('country');
            $table->string('city');
            $table->string('title');
            $table->string('price');
            $table->date('startdate');
            $table->date('enddate');
            $table->string('instagram');
            $table->string('facebook');
            $table->string('photo')->nullable();
            $table->text('Description');
            $table->text('status')->default(0);
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
        Schema::dropIfExists('retreats');
    }
}
