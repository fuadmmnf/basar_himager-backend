<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliverygroup extends Model
{
    use HasFactory;

    public function deliveries(){
        return $this->hasMany('App\Models\Delivery');
    }
}
