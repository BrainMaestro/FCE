<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('section_user');
    }
}
