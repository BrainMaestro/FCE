<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionQuestionSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_question_set', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_id')->index();
            $table->unsignedInteger('question_set_id')->index();
            $table->unsignedInteger('position');
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions');
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
        Schema::drop('question_question_set');
    }
}
