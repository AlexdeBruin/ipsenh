<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_info', function (Blueprint $table) {
            $table->string('student_number', 9)->primary();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('specialisation_id')->unsigned();
        });

        Schema::table('student_info', function (Blueprint $table){
            $table->foreign('specialisation_id')->references('id')->on('specialisations');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_info');
    }
}
