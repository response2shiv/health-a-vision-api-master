<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
//    use HasFactory, Notifiable;
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'phone', 
        'verification_string',
        'status',        
        'email',
        'password',
        'userRole',
        'testing_center_id',
        'HAVUserUniqueID',
        'isVarified',
        'dob',
        'idProofFile',
        'gender',
        'isRegistrationComplete',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'datetime',
    ];

    public function testingCenter()
    {
        return $this->belongsTo('App\Models\TestingCenter');
    }

    public function specialistAgent()
    {
        return $this->belongsTo('App\Models\Patient');
    }

    public function subscriptionPayments()
    {
        return $this->hasMany('App\Models\SubscriptionPayments');
    }

}
