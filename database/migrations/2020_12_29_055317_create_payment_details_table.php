<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $statusTypes = [
                'Fail' => "Fail",
                'Sucess' => "Sucess",
                'InProgress' => "InProgress",
            ];            
            $table->id();
            $table->string('transactionId')->nullable();
            $table->enum('status',array_keys($statusTypes));
            $table->integer('patient_subscription_id')->unsigned()->nullable();    
            // $table->foreign('patient_subscription_id')->references('id')->on('patient_subscriptions');
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
        Schema::dropIfExists('payment_details');
    }
}
