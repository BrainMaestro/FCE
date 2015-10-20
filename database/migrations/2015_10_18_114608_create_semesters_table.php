<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('semester');
            $table->string('midterm_evaluations')->default('Locked');
            $table->string('final_evaluations')->default('Locked');
            $table->unsignedInteger('midterm_question_set');
            $table->unsignedInteger('final_question_set');
            $table->timestamps();

            $table->foreign('midterm_question_set')->references('id')->on('question_sets');
            $table->foreign('final_question_set')->references('id')->on('question_sets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('semesters');
    }
}
