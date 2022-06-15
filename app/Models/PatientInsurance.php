<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientInsurance extends Model
{
    use HasFactory;
    protected $fillable = [
        'fromDate',
        'toDate',
        'policyNumber',
        'user_id',    
        'ma_id',
        'insuredName',
        'insuranceType',
        'nomineeName',
        'nomineeRelationship',
        'premiumDate',
        'dob',
        'inssurance_provider_id'

    ];

    protected $casts = [
        'fromDate' => 'datetime',
        'toDate' => 'datetime',
        'premiumDate' => 'datetime',
        'dob' => 'datetime',
    ];

    public function inssuranceProvider()
    {
        return $this->belongsTo('App\Models\InssuranceProvider');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


}
