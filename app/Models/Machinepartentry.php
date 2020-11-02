<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machinepartentry extends Model
{
    use HasFactory;

    public function machinepart(){
        return $this->belongsTo('App\Models\Machinepart');
    }
}
