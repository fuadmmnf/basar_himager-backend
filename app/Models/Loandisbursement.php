<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loandisbursement extends Model
{
    use HasFactory;

    public function booking ()
    {
        return $this->belongsTo('App\Models\Booking');
    }

    public function loancollections(){
        return $this->hasMany('App\Models\Loancollection');
    }
}
