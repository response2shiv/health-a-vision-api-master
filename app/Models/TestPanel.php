<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestPanel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'tests',
        'ratelist',
        'testing_center_id',
        'amount'
    ];
/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function testingCenter()
    {
        return $this->belongsTo('App\Models\TestingCenter');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\TestBokking');
    }

}
