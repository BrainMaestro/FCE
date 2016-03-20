<?php

use Fce\Models\Section;
use Fce\Utility\Status;
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
            $table->unsignedInteger('school_id')->index();
            $table->string('course_title');
            $table->string('class_time');
            $table->string('location');
            $table->enum('status', Status::STATUSES);
            $table->integer('enrolled');
            $table->timestamps();

            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('school_id')->references('id')->on('schools');
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
