<?php


namespace App\Repositories;


use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class InventoryRepository implements Interfaces\InventoryRepositoryInterface
{

    public function saveInventory(array $request)
    {
        // TODO: Implement saveInventory() method.
        $inventory = Inventory::where('name',$request['name'])
                                ->where('category', $request['category'])
                                ->where('parent_id',$request['parent_id'])->first();
        $newInventory = new Inventory();

        if($inventory){
            return 'AlreadyExisting';
        }

        DB::beginTransaction();
        try{
//            if($request['parent_id'] !== null){
//                $parentInventory = Inventory::where('id',$request['parent_id'])->first();
//                if($parentInventory->remaining_capacity < $request['capacity']){
//                    return 'NotEnoughCapacity';
//                }
//                else {
//                    Inventory::where('id',$request['parent_id'])->decrement('remaining_capacity', $request['capacity']);
//                }
//
//            }
            $newInventory->parent_id = $request['parent_id'];
            $newInventory->category = $request['category'];
            $newInventory->name = $request['name'];
            $newInventory->current_quantity = $request['current_quantity'];
//            $newInventory->remaining_capacity = $request['remaining_capacity'];
            $newInventory->save();

        }catch (\Exception $e){
            DB::rollback();
        }
        DB::commit();
        return $newInventory;
    }

    public function getInventory($inventory_type)
    {
        // TODO: Implement getInventory() method.
        $inventories = Inventory::where('category', $inventory_type)->get();
        //if($inventory_type !== 'chamber' && $inventory_type!== 'position'){
            foreach ($inventories as $inventory){
                $this->getFullInventoryDecisionWithParent($inventory);
            }
       // }
        return $inventories;
    }
    private function getFullInventoryDecisionWithParent($inventory){
                if($inventory->parent_id !== null){
                    $temp= Inventory::where('id', $inventory->parent_id)->first();
                    $inventory->parent_info = $temp;
                    $this->getFullInventoryDecisionWithParent($inventory->parent_info);
                }
                return $inventory;
    }


    public function fetchInventoryByParentId($parent_id)
    {
        // TODO: Implement fetchInventoryByParentId() method.
        $temp = Inventory::where('parent_id', $parent_id)->get();
        return $temp;
    }
}
