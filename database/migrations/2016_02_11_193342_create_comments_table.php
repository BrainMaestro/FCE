<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('section_id')->index();
            $table->unsignedInteger('question_set_id')->index();
            $table->text('comment');
            $table->timestamps();

            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('question_set_id')->references('id')->on('question_sets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }
}
