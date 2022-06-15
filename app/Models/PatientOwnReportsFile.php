<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientOwnReportsFile extends Model
{
    use HasFactory;
    protected $fillable = [
        "fileType",
        "uploadedName",
        "orignalName",
        "folder_id",
        'user_id',
        'size',
        'entityType'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }  

    public function folder()
    {
        return $this->belongsTo('App\Models\PatientOwnReportsFolder');
    }  


}
