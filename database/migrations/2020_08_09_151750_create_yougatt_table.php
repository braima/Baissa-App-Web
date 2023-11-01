<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYougattTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yougatt', function (Blueprint $table) {
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
            $table->string('image')->nullable();
            $table->text('Description');
            $table->text('titleinfo');
            $table->text('yogastyle');
            $table->text('aboutteacher');
            $table->text('yogacourse');
            $table->text('locationcourse');
            $table->text('accomondation');
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
        Schema::dropIfExists('yougatt');
    }
}
