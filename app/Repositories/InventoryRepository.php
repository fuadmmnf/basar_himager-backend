<?php


namespace App\Repositories;


use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class InventoryRepository implements Interfaces\InventoryRepositoryInterface
{

    public function saveInventory(array $request)
    {
        // TODO: Implement saveInventory() method.
        $inventory = Inventory::where('name',$request['name'])->where('category', $request['category'])->first();

        if($inventory){
            return 'AlreadyExisting';
        }

        DB::beginTransaction();
        try{
            if($request['parent_id'] !== null){
                $parentInventory = Inventory::where('parent_id',$request['parent_id'])->first();
                if($parentInventory->remaining_capacity < $request['capacity']){
                    return 'NotEnoughCapacity';
                }
                else Inventory::where('parent_id',$request['parent_id'])->decrement('remaing_capacity', $request['capacity']);

            }
            $newInventory = new Inventory();
            $newInventory->parent_id = $request['parent_id'];
            $newInventory->category = $request['category'];
            $newInventory->name = $request['name'];
            $newInventory->capacity = $request['capacity'];
            $newInventory->remaining_capacity = $request['remaining_capacity'];
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
        if($inventory_type !== 'chamber' || $inventory_type!== 'position'){
            foreach ($inventories as $inventory){
                $this->getFullInventoryDecisionWithParent($inventory);
            }
        }
        return $inventories;
    }
    public function getFullInventoryDecisionWithParent($inventory){
                while($inventory->parent_id !== null){
                    $temp= Inventory::where('parent_id', $inventory->parent_id)->get();
                    $inventory->parent_info = $temp;
                    $this->getFullInventoryDecisionWithParent($inventory->parent_info);
                }
                return $inventory;
    }

}
