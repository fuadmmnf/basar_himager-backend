<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $casts = [
        'address' => 'array'
    ];


    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function bookings(){
        return $this->hasMany('App\Models\Booking');
    }
}
