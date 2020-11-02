<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamberentry extends Model
{
    use HasFactory;

    public function chamber()
    {
        return $this->belongsTo('App\Models\Chamber');
    }
}
