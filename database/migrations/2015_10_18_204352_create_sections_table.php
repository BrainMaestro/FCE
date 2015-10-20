<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('crn')->index();
            $table->string('course_code');
            $table->unsignedInteger('semester_id');
            $table->unsignedInteger('school')->index();
            $table->string('course_title');
            $table->string('class_time');
            $table->string('location');
            $table->boolean('locked');
            $table->integer('enrolled');
            $table->boolean('midterm_evaluation');
            $table->boolean('final_evaluation');
            $table->timestamps();

            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('school')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sections');
    }
}
