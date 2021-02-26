<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loaddistribution extends Model
{
    use HasFactory;

    protected $casts = [
        'potato_type' => 'array'
    ];

    public function receive(){
        return $this->belongsTo('App\Models\Receive');
    }

    public function receiveitems(){
        return $this->hasMany('App\Models\Receiveitem');
    }
}
