<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('client');
            $table->unsignedInteger('category_room');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('places');
            $table->unsignedInteger('room_id')->nullable();
            $table->boolean('booking_status')->default(0);
            $table->timestamps();

            $table->foreign('client')->references("id")->on('users');
            $table->foreign('category_room')->references("id")->on('categories');
            $table->foreign('room_id')->references("id")->on('rooms');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
