<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientVitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_vitals', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('age')->unsigned()->nullable();
            $table->integer('height')->unsigned()->nullable();
            $table->integer('weight')->unsigned()->nullable();
            $table->string('bloodGroup')->nullable();
            $table->longText('previousSurgeries')->nullable();
            $table->longText('metabolicDiseases')->nullable();
            $table->longText('allergies')->nullable();
            $table->longText('gastroIntestinal')->nullable();


            $table->integer('patient_id')->unsigned()->nullable();    
            $table->foreign('patient_id')->references('id')->on('patients');        

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_vitals');
    }
}
