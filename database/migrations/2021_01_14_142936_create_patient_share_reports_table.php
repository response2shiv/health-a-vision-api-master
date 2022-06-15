<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientShareReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_share_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('own_report_id')->unsigned()->nullable();    
            $table->foreign('own_report_id')->references('id')->on('patient_own_reports_files');
            $table->integer('test_book_id')->unsigned()->nullable();    
            $table->foreign('test_book_id')->references('id')->on('test_bokkings');
            $table->integer('doctor_id')->unsigned()->nullable();    
            $table->foreign('doctor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_share_reports');
    }
}
