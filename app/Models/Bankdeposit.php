<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankdeposit extends Model
{
    use HasFactory;
    public function bank(){
        return $this->belongsTo('App\Models\Bank');
    }
}
