<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyHavIds extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'patient_id',
        'user_id'
    ];

    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }

}
