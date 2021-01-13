<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unloading extends Model
{
    use HasFactory;

    public function delivery ()
    {
        return $this->belongsTo('App\Models\Delivery');
    }
}
