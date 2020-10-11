<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public function receives(){
    }

    public function client(){
        return $this->belongsTo('App\Models\Client');
    }
}
