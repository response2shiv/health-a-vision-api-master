<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_package_id',
        'patient_id',
    ];

    public function patientPackage()
    {
        return $this->belongsTo('App\Models\PatientPackage');
    }
    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }
}
