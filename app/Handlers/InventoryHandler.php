<?php


namespace App\Handlers;


use App\Models\Chamberentry;
use App\Models\Inventory;
use Carbon\Carbon;

class InventoryHandler
{
    public function fetchFullInventoryWithParentBYId($id){
        $inventory = Inventory::where('id',$id)->first();
        $inventory = $this->getFullInventoryDecisionWithParent($inventory);
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
    public function saveChamberStageChange($chamber_id,$stage,Carbon $date)
    {
        $chamber = Inventory::findOrFail($chamber_id);

        $newChamberentry = new Chamberentry();
        $newChamberentry->chamber_id = $chamber->id;
        $newChamberentry->stage = $stage;
        $newChamberentry->date = $date;
        $newChamberentry->save();

        $chamber->stage = $newChamberentry->stage = $stage;
        $chamber->save();

        return $newChamberentry;
    }
}
