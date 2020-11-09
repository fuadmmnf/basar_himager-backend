<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    use HasFactory;

    protected $casts = [
        'transport' => 'array'
    ];

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking');
    }

    public function receiveitems()
    {
        return $this->hasMany('App\Models\Receiveitem');
    }
}
