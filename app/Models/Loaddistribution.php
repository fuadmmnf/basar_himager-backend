<?php

namespace App\Models;

use App\Handlers\InventoryHandler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loaddistribution extends Model
{
    use HasFactory;
    protected $appends = ['inventory_tree'];

    protected $casts = [
        'potato_type' => 'array'
    ];

    public function getInventoryTreeAttribute()
    {
        $inventoryHandler = new InventoryHandler();
        return  $inventoryHandler->fetchFullInventoryWithParentBYId($this->attributes['compartment_id']);
    }
    public function receive(){
        return $this->belongsTo('App\Models\Receive');
    }

    public function receiveitem(){
        return $this->belongsTo('App\Models\Receiveitem');
    }

    public function unloadings(){
        return $this->hasMany('App\Models\Unloading');
    }
}
