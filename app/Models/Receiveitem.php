<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receiveitem extends Model
{
    use HasFactory;

    public function receive(){
        return $this->belongsTo('App\Models\Receive');
    }

    public function loaddistributions(){
        return $this->hasMany('App\Models\Loaddistribution');
    }
}
