<?php

namespace App\Repositories;

use App\Models\Inventory;
use App\Models\Loaddistribution;
use App\Models\Receiveitem;
use App\Repositories\Interfaces\LoaddistributionRepositoryInterface;
use Illuminate\Support\Facades\DB;


class LoaddistributionRepository implements LoaddistributionRepositoryInterface
{


    public function saveLoaddistrbution(array $request)
    {
        // TODO: Implement saveLoaddistrbution() method.

        DB::beginTransaction();
        try{
            $id = $request['receive_id'];
            $compartment = $request['compartment_id'];

            $inventories = Inventory::where('id', $compartment)->first();
            $floor = Inventory::where('id',$inventories->parent_id)->first();
            $chamber = Inventory::where('id',$floor->parent_id)->first();

            foreach ($request['distributions'] as $distribution){
                $newLoaddistribution=new Loaddistribution();

                $newLoaddistribution->receive_id = $id;
                $newLoaddistribution->compartment_id = $compartment;
                $newLoaddistribution->potato_type = $distribution['potato_type'];
                $newLoaddistribution->quantity = $distribution['quantity'];
                $newLoaddistribution->save();

                $receiveItem = Receiveitem::where('receive_id',$id)->where('potatoe_type',$distribution['potato_type'])->first();
                $receiveItem->loaded_quantity = $receiveItem->loaded_quantity + $distribution['quantity'];
                $receiveItem->save();

                $inventories->current_quantity = $inventories->current_quantity + $distribution['quantity'];
                $inventories->save();
                $floor->current_quantity = $floor->current_quantity + $distribution['quantity'];
                $floor->save();
                $chamber->current_quantity = $chamber->current_quantity + $distribution['quantity'];
                $chamber->save();
            }
        }catch (\Exception $e){
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $newLoaddistribution;
    }

    public function getLoadDistributions($receive_id){
        $loaddistributions = Loaddistribution::where('receive_id',$receive_id)->orderByDesc('createded_at')->all();
        foreach ($loaddistributions as $loaddistribution){
            $loaddistribution->inventory = $this->fetchFullInventoryWithParentBYId($loaddistribution->compartment_id);
        }
        return $loaddistributions;
    }

    private function fetchFullInventoryWithParentBYId($id){
        $inventory = Inventory::where('id',$id)->first();
        $this->getFullInventoryDecisionWithParent($inventory);
        return $inventory;
    }
    private function getFullInventoryDecisionWithParent($inventory){
        if($inventory->parent_id !== null){
            $temp= Inventory::where('id', $inventory->parent_id)->first();
            $inventory->parent_info = $temp;
            $this->getFullInventoryDecisionWithParent($inventory->parent_info);
        }
        return $inventory;
    }
}
