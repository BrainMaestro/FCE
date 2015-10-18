<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collate = 'utf8_unicode_ci';

            $table->increments('id')->unsigned();
            $table->integer('crn')->index();
            $table->string('course_code');
            $table->string('semester');
            $table->unsignedInteger('school')->index();
            $table->foreign('school')->references('id')->on('schools');
            $table->string('course_title');
            $table->string('class_time');
            $table->string('location');
            $table->boolean('locked');
            $table->integer('enrolled');
            $table->boolean('mid_evaluation');
            $table->boolean('final_evaluation');
            $table->timestamps();
            $table->softDeletes();
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
