<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'firstName',
        'lastName',
        'gender',
        'email',
        'phone', 
        'dob',
        'HAVPatientID',
        'addressline1',
        'addressline2',
        'city', 
        'state',
        'state_short_name',
        'postalCode',        
        'country',
        'testing_center_id',
        'specialist_agent_id',
        'idProofType',
        'idProofFile',
        'own_user_id',
        'referredBy'
    ];

    public function testingCenter()
    {
        return $this->belongsTo('App\Models\TestingCenter');
    }

    public function specialistAgent()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\TestBokking');
    }

}
