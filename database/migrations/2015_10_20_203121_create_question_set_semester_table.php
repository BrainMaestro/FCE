<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionSetSemesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_set_semester', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_set_id');
            $table->unsignedInteger('semester_id');
            // Evaluation type can be expanded to include more types of evaluations
            $table->enum('evaluation_type', ['midterm', 'final']);
            $table->enum('status', ['Locked', 'Open', 'Done']);
            $table->timestamps();

            $table->foreign('question_set_id')->references('id')->on('question_sets');
            $table->foreign('semester_id')->references('id')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('question_set_semester');
    }
}
