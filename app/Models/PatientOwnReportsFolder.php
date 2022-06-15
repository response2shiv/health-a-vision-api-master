<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientOwnReportsFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'folderName',
        'stared',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }  
}
