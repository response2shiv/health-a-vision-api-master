<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestingCenter extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'addressline1',
        'addressline2',
        'city', 
        'state',
        'postalCode',        
        'country',
        'HAVTestCenterUniqueID',
        'prefix',
        'email',
        'phone',
        'phone2',
        'registrationNo',
        'license'
    ];

    public function patients()
    {
        return $this->hasMany('App\Models\Patient');
        // or
        //return $this->hasMany('App\Models\Patient','testing_center_id');
    }

    public function testPanels()
    {
        return $this->hasMany('App\Models\TestPanel');
        // or
        //return $this->hasMany('App\Models\Patient','testing_center_id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
        // or
        //return $this->hasMany('App\Models\Patient','testing_center_id');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\TestBokking');
    }

}
