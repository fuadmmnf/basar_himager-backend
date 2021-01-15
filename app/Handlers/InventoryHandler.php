<?php


namespace App\Handlers;


use App\Models\Inventory;

class InventoryHandler
{
    public function fetchFullInventoryWithParentBYId($id){
        $inventory = Inventory::where('id',$id)->first();
        $this->getFullInventoryDecisionWithParent($inventory);
        return $inventory;
    }

    public function getFullInventoryDecisionWithParent($inventory){
        if($inventory->parent_id !== null){
            $temp= Inventory::where('id', $inventory->parent_id)->first();
            $inventory->parent_info = $temp;
            $this->getFullInventoryDecisionWithParent($inventory->parent_info);
        }
        return $inventory;
    }

    public function makeChamberStage0($name){

    }
}
