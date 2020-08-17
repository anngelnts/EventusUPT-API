<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->integer('school_id')->unsigned();
            $table->integer('organizer_id')->unsigned();
            $table->string('title', 200);
            $table->string('description', 200)->nullable();
            $table->string('image', 200)->nullable();
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_outstanding');
            $table->boolean('is_virtual');
            $table->boolean('is_open');
            $table->string('location', 200)->nullable();
            $table->string('event_link', 200)->nullable();
            $table->unsignedInteger('status');
            $table->timestamps();
            $table->foreign('type_id')->references('id')->on('event_types');
            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('organizer_id')->references('id')->on('organizers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
