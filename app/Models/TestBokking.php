<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestBokking extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'testpanel_id',
        'testing_center_id',
        'appointment_at',
        'paymentStatus',
        'testStatus',
        'file',
        'paymentMode',
    ];

    protected $casts = [
        'appointment_at' => 'datetime',
    ];


    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }

    public function testpanel()
    {
        return $this->belongsTo('App\Models\TestPanel');
    }

    public function testingCenter()
    {
        return $this->belongsTo('App\Models\TestingCenter');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\TestBookingReports');
    }

}
