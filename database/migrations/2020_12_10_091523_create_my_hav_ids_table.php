<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyHavIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_hav_ids', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('patient_id')->unsigned()->nullable();    
            $table->foreign('patient_id')->references('id')->on('patients');        

            $table->integer('user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('my_hav_ids');
    }
}
