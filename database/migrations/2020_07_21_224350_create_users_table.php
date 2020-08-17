<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('audience_id')->unsigned();
            $table->string('name', 100);
            $table->string('lastname', 100);
            $table->string('phone', 50)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password', 200);
            $table->rememberToken();
            $table->unsignedInteger('status');
            $table->timestamps();
            $table->foreign('audience_id')->references('id')->on('audiences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
