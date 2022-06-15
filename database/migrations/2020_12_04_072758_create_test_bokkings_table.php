<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestBokkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_bokkings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('patient_id')->unsigned()->nullable();
            $table->integer('testpanel_id')->unsigned()->nullable();
            $table->integer('testing_center_id')->unsigned()->nullable();

            // $table->integer('testpanel_id')->unsigned()->nullable();
            // $table->integer('testing_center_id')->unsigned()->nullable();

             //$table->foreign('patient_id')->references('id')->on('patients');
            //  $table->foreign('testpanel_id')->references('id')->on('test_panels');                        
            //  $table->foreign('testing_center_id')->references('id')->on('testing_centers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_bokkings');
    }
}
