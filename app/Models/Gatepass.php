<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gatepass extends Model
{
    use HasFactory;
    protected $casts = [
        'transport' => 'array'
    ];

    public function delivery(){
        return $this->belongsTo('App\Models\Delivery');
    }
}
