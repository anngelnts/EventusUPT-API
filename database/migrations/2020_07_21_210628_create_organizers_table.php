<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->string('acronym', 100);
            $table->string('phone', 50)->nullable();
            $table->string('website', 100)->nullable();
            $table->string('facebook', 100)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password', 200);
            $table->rememberToken();
            $table->unsignedInteger('status');
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
        Schema::dropIfExists('organizers');
    }
}
