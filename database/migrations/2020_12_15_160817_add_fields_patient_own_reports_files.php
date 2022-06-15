<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsPatientOwnReportsFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('patient_own_reports_files', function (Blueprint $table) {
            $entityTypes = [
                'TEST_REPORT' => "TEST_REPORT",
                'DOCTOR_PRESCRIPTION' => "DOCTOR_PRESCRIPTION",
                'OTHER' => "OTHER",
            ];            
            $table->float('size')->unsigned()->nullable();
            $table->enum('entityType',array_keys($entityTypes))->nullable();

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
