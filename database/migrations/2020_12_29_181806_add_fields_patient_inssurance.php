<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsPatientInssurance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_insurances', function (Blueprint $table) {
            $table->string('insuredName')->nullable();
            $table->string('insuranceType')->nullable();
            $table->string('nomineeName')->nullable();
            $table->string('nomineeRelationship')->nullable();
            $table->date('premiumDate')->nullable();
            $table->date('dob')->nullable();
            $table->integer('inssurance_provider_id')->unsigned()->nullable();    
            $table->foreign('inssurance_provider_id')->references('id')->on('inssurance_providers');

        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
