<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('first_name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('phone');
            $table->boolean('is_corporate')->nullable();
            $table->string('corporate_name')->nullable();
            $table->string('client')->nullable();
            $table->string('password');
            $table->string('password_repeat');
            $table->boolean('is_admin')->nullable();
            $table->boolean('role')->nullable();
            $table->string('api_token')->nullable();
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
        Schema::dropIfExists('users');
    }
}
