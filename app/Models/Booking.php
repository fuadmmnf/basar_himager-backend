<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public function receives(){
        return $this->hasMany('App\Models\Receive');
    }

    public function deliveries(){
        return $this->hasMany('App\Models\Delivery');
    }

    public function loanDisbursements(){
        return $this->hasMany('App\Models\Loandisbursement');
    }

    public function loanCollections(){
        return $this->hasMany('App\Models\Loancollection');
    }
}
