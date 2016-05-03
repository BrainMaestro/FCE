<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->enum('name', ['admin', 'sas-dean', 'sbe-dean', 'sitc-dean', 'executive', 'faculty', 'secretary', 'helper']);
            $table->enum('display_name', ['Administrator', 'SAS Dean', 'SBE Dean', 'SITC Dean', 'Executive', 'Faculty', 'Secretary', 'Helper'])->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
