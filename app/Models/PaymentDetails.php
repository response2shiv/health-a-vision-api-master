<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'transactionId',
        'status',
        'patient_subscription_id',
        'patient_id',     
    ];

    public function patientSubscription()
    {
        return $this->belongsTo('App\Models\PatientSubscription');
    }
    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }
}
