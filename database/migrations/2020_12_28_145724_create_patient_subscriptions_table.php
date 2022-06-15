<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_package_id')->unsigned()->nullable();    
            // $table->foreign('patient_package_id')->references('id')->on('Patient_Packages');
            $table->integer('patient_id')->unsigned()->nullable();    
            $table->foreign('patient_id')->references('id')->on('patients');
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
        Schema::dropIfExists('patient_subscriptions');
    }
}
