<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsTestBokkings2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_bokkings', function (Blueprint $table) {
            $table->dateTime('appointment_at')->nullable();
        });    
        
    }

    protected $casts = [
        'appointment_at' => 'datetime',
    ];

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
