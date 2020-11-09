<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machinepart extends Model
{
    use HasFactory;

    public function machinepartentries()
    {
        return $this->hasMany('App\Models\Machinepartentry');
    }
}
