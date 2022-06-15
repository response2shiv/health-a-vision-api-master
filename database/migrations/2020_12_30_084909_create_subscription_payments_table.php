<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $statusTypes = [
                'Pending' => "Pending",
                'Success' => "Success",
                'In Progress' => "In Progress",
                'Failed' => "Failed",
                'Cancelled' => "Cancelled",
            ];            
            $table->string('transactionId', 191)->nullable()->unique();
            $table->enum('status',array_keys($statusTypes));

            $table->integer('user_id')->unsigned()->nullable();    
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('master_subscription_package_id')->unsigned()->nullable();    
            $table->foreign('master_subscription_package_id')->references('id')->on('master_subscription_packages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_payments');
    }
}
