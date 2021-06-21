<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('course_id')->unsigned();
            $table->string('name', 10);
            $table->integer('percentage');
            $table->boolean('mandatory');
            $table->integer('semester');
            $table->dateTime('given_at');
            $table->boolean('retake');
            $table->boolean('grades_inserted');
            $table->timestamps();
        });
        Schema::table('tests', function(Blueprint $table){
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
