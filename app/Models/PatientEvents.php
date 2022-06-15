<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientEvents extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start',
        'end',
        'patient_id'
    ];

    // protected $casts = [
    //     'start' => 'datetime',
    //     'end' => 'datetime'
    // ];
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime'
    ];

    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }
}
