<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('section_id')->index();
            $table->unsignedInteger('question_id')->index();
            $table->unsignedInteger('one')->default(0);
            $table->unsignedInteger('two')->default(0);
            $table->unsignedInteger('three')->default(0);
            $table->unsignedInteger('four')->default(0);
            $table->unsignedInteger('five')->default(0);
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('evaluations');
    }
}
