<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestPanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_panels', function (Blueprint $table) {
            //$table->id();
            $table->increments('id');	
            $table->text('name')->nullable();
            $table->text('category')->nullable();
            $table->text('tests')->nullable();
            $table->float('ratelist')->nullable();
            $table->integer('testing_center_id')->unsigned()->nullable();
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
        Schema::dropIfExists('test_panels');
    }
}
