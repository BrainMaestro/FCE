<?php

use Fce\Utility\Status;
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
            $table->string('evaluation_type');
            // Include all the available statuses except 'In progress'.
            $table->enum('status', [
                Status::LOCKED,
                Status::OPEN,
                Status::DONE,
            ])->default(Status::LOCKED);
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
