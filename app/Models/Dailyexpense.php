<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dailyexpense extends Model
{
    use HasFactory;
    public function expensecategory(){
        return $this->belongsTo('App\Models\Expensecategory');
    }
}
