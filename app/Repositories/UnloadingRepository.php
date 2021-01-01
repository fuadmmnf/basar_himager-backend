<?php


namespace App\Repositories;


use App\Models\Inventory;
use App\Models\Loaddistribution;
use App\Models\Unloading;
use App\Repositories\Interfaces\UnloadingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UnloadingRepository implements UnloadingRepositoryInterface
{

    public function createUnloadingEntry(array $request)
    {
        // TODO: Implement createUnloadingEntry() method.
        DB::beginTransaction();
        try{
            $booking_id = $request['booking_id'];
            $delivery_id = $request['delivery_id'];
//loaddistribution_id
            foreach ($request['unloadings'] as $unloading){

                $loaddistribution = Loaddistribution::where('id', $unloading['loaddistribution_id'])->first();
                $loaddistribution->current_quantity = $loaddistribution->current_quantity - $unloading['quantity'];
                $compartment_id = $loaddistribution->compartment_id;
                $loaddistribution->save();


                $inventories = Inventory::where('id', $compartment_id)->first();
                $floor = Inventory::where('id',$inventories->parent_id)->first();
                $chamber = Inventory::where('id',$floor->parent_id)->first();

                if($inventories->current_quantity >= $unloading['quantity']){
                    $inventories->current_quantity = $inventories->current_quantity - $unloading['quantity'];
                    $inventories->save();
                }else return 'QuantityNotAvailable';

                if($floor->current_quantity >= $unloading['quantity']){
                    $floor->current_quantity = $floor->current_quantity - $unloading['quantity'];
                    $floor->save();
                }else return 'QuantityNotAvailable';

                if($chamber->current_quantity >= $unloading['quantity']){
                    $chamber->current_quantity = $chamber->current_quantity - $unloading['quantity'];
                    $chamber->save();
                }else return 'QuantityNotAvailable';

                $newUnloading =new Unloading();

                $newUnloading->booking_id = $booking_id;
                $newUnloading->delivery_id = $delivery_id;
                $newUnloading->loaddistribution_id = $unloading['loaddistribution_id'];
                $newUnloading->potato_type = $unloading['potato_type'];
                $newUnloading->quantity = $unloading['quantity'];
                $newUnloading->save();

            }
        }catch (\Exception $e){
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $newUnloading;
    }
}
