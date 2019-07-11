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
            $table->string('event_name');
            $table->string('event_desc')->nullable();
            //0 = Ongoing; 1 = Upcoming; 2 = Finished;
            $table->integer('event_status')->nullable();
            $table->dateTime('event_start');
            $table->dateTime('event_finish');
            $table->integer('evcat_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });
        Schema::table('events', function($table) {
            $table->foreign('evcat_id')->references('id')->on('event_categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
