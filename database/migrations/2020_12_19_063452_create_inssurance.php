<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInssurance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('patient_insurances', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->timestamps();
        //     $table->string('insurance_provider')->nullable();
        //     $table->dateTimeTz('fromDate')->nullable();
        //     $table->dateTimeTz('toDate')->nullable();
        //     $table->longText('policyNumber')->nullable();
        //     $table->integer('user_id')->unsigned()->nullable();    
        //     $table->foreign('user_id')->references('id')->on('users');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inssurance');
    }
}
