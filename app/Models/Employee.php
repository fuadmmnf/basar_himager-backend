<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',

    ];
    protected $casts = [
        'present_address' => 'array',
        'permanent_address' => 'array',
    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function salary(){
        return $this->hasMany('App\Models\Employeesalary');
    }
    public function loan(){
        return $this->hasMany('App\Models\Employeeloan');
    }
}
