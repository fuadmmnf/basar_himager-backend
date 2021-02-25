<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receivegroup extends Model
{
    use HasFactory;

    public function receives(){
        return $this->hasMany('App\Models\Receive');
    }
}
