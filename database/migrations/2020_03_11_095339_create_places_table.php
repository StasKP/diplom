<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('name');

            $table->unsignedInteger('room_id');

            $table->boolean('is_empty');
            $table->boolean('is_primary');

            $table->unsignedInteger('client')->nullable();

            $table->timestamps();

            $table->foreign('room_id')->references("id")->on('rooms')->onDelete('cascade');
            $table->foreign('client')->references("id")->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
}
