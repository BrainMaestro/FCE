<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collate = 'utf8_unicode_ci';

            $table->increments('id')->unsigned();
            $table->unsignedInteger('section_id')->index();
            $table->foreign('section_id')->references('id')->on('sections');
            $table->unsignedInteger('question_id')->index();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->unsignedInteger('question_metadata_id')->nullable();
            $table->foreign('question_metadata_id')->references('id')->on('question_metadatas');
            $table->unsignedInteger('one')->nullable();
            $table->unsignedInteger('two')->nullable();
            $table->unsignedInteger('three')->nullable();
            $table->unsignedInteger('four')->nullable();
            $table->unsignedInteger('five')->nullable();
            $table->string('comment')->nullable();
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
        Schema::drop('evaluations');
    }
}
