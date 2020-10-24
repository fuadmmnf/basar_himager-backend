<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loancollection extends Model
{
    use HasFactory;

    public function loandisbursement()
    {
        return $this->belongsTo('App\Models\Loandisbursement');
    }
}
