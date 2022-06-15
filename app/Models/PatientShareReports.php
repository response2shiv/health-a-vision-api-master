<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientShareReports extends Model
{
    use HasFactory;
    protected $fillable = [
        'own_report_id',
        'test_book_id',
        'doctor_id',
    ];

    public function ownReport()
    {
        return $this->belongsTo('App\Models\PatientOwnReportsFile');
    }

    public function testBook()
    {
        return $this->belongsTo('App\Models\TestBokking');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\User');
    }
}
