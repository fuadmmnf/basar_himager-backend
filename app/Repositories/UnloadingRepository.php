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

            foreach ($request['unloadings'] as $unloading){

                $inventories = Inventory::where('id', $unloading['compartment_id'])->first();
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

                $loaddistribution = Loaddistribution::where('booking_id', $booking_id)
                    ->where('compartment_id',$unloading['compartment_id'])
                    ->where('potato_type',$unloading['potato_type'])-get();
                $loaddistribution->current_quantity = $loaddistribution->current_quantity - $unloading['quantity'];
                $loaddistribution->save();

                $newUnloading =new Unloading();

                $newUnloading->booking_id = $booking_id;
                $newUnloading->delivery_id = $delivery_id;
                $newUnloading->compartment_id = $unloading['compartment_id'];
                $newUnloading->potato_type = $unloading['potato_type'];
                $newUnloading->quantity = $newUnloading['quantity'];
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
