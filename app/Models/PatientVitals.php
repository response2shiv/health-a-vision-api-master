<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientVitals extends Model
{
    use HasFactory;

    protected $fillable = [
        'age',
        'height',
        'weight',
        'bloodGroup',
        'previousSurgeries',
        'metabolicDiseases',
        'allergies',
        'gastroIntestinal',
        'bloodPressure',
        'heartRate',
        'patient_id',    
    ];



    

}
