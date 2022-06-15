<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSubscriptionPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'packageKey',
        'displayName',
        'description',
        'storageLimit',
        'charges',
        'validityInDays'
    ];

}
