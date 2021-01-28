<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking');
    }

    public function deliverygroup()
    {
        return $this->belongsTo('App\Models\Deliverygroup');
    }

    public function deliveryitems()
    {
        return $this->hasMany('App\Models\Deliveryitem');
    }



    public function unloading()
    {
        return $this->hasMany('App\Models\Unloading');
    }
}
