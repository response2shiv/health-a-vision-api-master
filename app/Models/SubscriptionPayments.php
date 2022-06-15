<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayments extends Model
{
    use HasFactory;
    protected $fillable = [
        'transactionId',
        'status',
        'user_id',
        'master_subscription_package_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function masterSubscriptionPackage()
    {
        return $this->belongsTo('App\Models\MasterSubscriptionPackage');
    }

}
