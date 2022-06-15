<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'browser',
        'ip',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
