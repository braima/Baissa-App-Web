<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->default(2);
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->date('birthday');
            $table->string('phone');
            $table->string('nationality')->nullable();
            $table->string('immatriculation')->nullable();
            $table->string('carmarque')->nullable();
            $table->string('carmodel')->nullable();
            $table->string('caryear')->nullable();
            $table->string('permis')->nullable();
            $table->string('vtccarte')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->default('default.png');
            $table->rememberToken();
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
        Schema::dropIfExists('usersys');
    }
}
