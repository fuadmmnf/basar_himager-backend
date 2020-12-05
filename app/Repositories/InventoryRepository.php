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
        $inventory = Inventory::where('category', $inventory_type)->get();
        return $inventory;
    }

}
