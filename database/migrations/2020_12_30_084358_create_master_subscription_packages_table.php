<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterSubscriptionPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_subscription_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('packageKey', 191)->unique()->nullable();
            $table->string('displayName')->nullable();
            $table->longText('description')->nullable();
            $table->bigInteger('storageLimit')->nullable();
            $table->float('charges')->nullable();
            $table->string('validityInDays')->nullable();
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
        Schema::dropIfExists('master_subscription_packages');
    }
}
