<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsTestingBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_bokkings', function (Blueprint $table) {
            $entityTypes = [
                'Credit Card' => "Credit Card",
                'Debit Card' => "Debit Card",
                'Cash' => "Cash",
                'Other' => "Other",
            ];            
            $table->enum('paymentMode',array_keys($entityTypes));
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
