<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('test_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->float('grade', 2, 1)->nullable();
            $table->timestamps();
        });

        Schema::table('test_user', function (Blueprint $table){
            $table->foreign('test_id')->references('id')->on('tests');
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
        Schema::dropIfExists('test_user');
    }
}
