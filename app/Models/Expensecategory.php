<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expensecategory extends Model
{
    use HasFactory;
    public function dailyexpenses(){
        return $this->hasMany('App\Models\Dailyexpense');
    }
}
