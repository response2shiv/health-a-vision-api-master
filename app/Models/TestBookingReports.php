<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestBookingReports extends Model
{
    use HasFactory;
    protected $fillable = [
        "fileType",
        "uploadedName",
        "orignalName",
        "booking_id"
    ];


    public function bookings()
    {
        return $this->belongsTo('App\Models\TestBokking');
    }  

}
