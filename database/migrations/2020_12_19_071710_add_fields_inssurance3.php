<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInssurance3 extends Migration
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
        //     $table->timestamp('fromDate')->nullable();
        //     $table->timestamp('toDate')->nullable();
        //     $table->longText('policyNumber')->nullable();
        //     $table->string('ma_id')->nullable();
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
        //
    }
}
