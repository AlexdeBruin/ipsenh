<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spec_id')->unsigned();
            $table->string('course_code', 25);
            $table->text('course_description');
            $table->json('semester');
            $table->integer('year');
            $table->integer('ec');
        });
        Schema::table('courses', function(Blueprint $table){
            $table->foreign('spec_id')->references('id')->on('specialisations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
