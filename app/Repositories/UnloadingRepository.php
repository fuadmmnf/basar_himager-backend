<?php


namespace App\Repositories;


use App\Handlers\InventoryHandler;
use App\Models\Chamber;
use App\Models\Chamberentry;
use App\Models\Deliveryitem;
use App\Models\Inventory;
use App\Models\Loaddistribution;
use App\Models\Unloading;
use App\Repositories\Interfaces\UnloadingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
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
            $deliveryItems = Deliveryitem::where('delivery_id', $delivery_id)->get();

            $unloadingItems = [];
            foreach ($request['unloadings'] as $unloading){
                if(isset($unloadingItems[$unloading['potato_type']])){
                    $unloadingItems[$unloading['potato_type']] += $unloading['quantity'];
                } else {
                    $unloadingItems[$unloading['potato_type']] = $unloading['quantity'];
                }
            }
            foreach ($deliveryItems as $deliveryItem){
                if($unloadingItems[$deliveryItem->potato_type] > $deliveryItem->quantity){
                    throw new \Exception('Unloading amount must be less then loading amount');
                }
            }


            foreach ($request['unloadings'] as $unloading){

                $loaddistribution = Loaddistribution::where('id', $unloading['loaddistribution_id'])->first();

                if($this->checkVisibility($loaddistribution->current_quantity , $unloading['quantity'])){
                    $loaddistribution->current_quantity = $loaddistribution->current_quantity - $unloading['quantity'];
                }else throw new \Exception('Loading amount limit exceed.');

                $compartment_id = $loaddistribution->compartment_id;
                $loaddistribution->save();


                $inventories = Inventory::where('id', $compartment_id)->first();
                $floor = Inventory::where('id',$inventories->parent_id)->first();
                $chamber = Inventory::where('id',$floor->parent_id)->first();

                if($this->checkVisibility($inventories->current_quantity , $unloading['quantity'])){
                    $inventories->current_quantity = $inventories->current_quantity - $unloading['quantity'];
                    $inventories->save();
                }else throw new \Exception('Loading amount limit exceed.');

                if($this->checkVisibility($floor->current_quantity , $unloading['quantity'])){
                    $floor->current_quantity = $floor->current_quantity - $unloading['quantity'];
                    $floor->save();
                }else throw new \Exception('Loading amount limit exceed.');

                if($this->checkVisibility($chamber->current_quantity , $unloading['quantity'])){

                    $chamber->current_quantity = $chamber->current_quantity - $unloading['quantity'];
                    $chamber->save();
                    if($chamber->current_quantity == 0)
                    {
                        //$chamberStage->stage = 'Stage-0';
                        $inventoryHandler = new InventoryHandler();
                        $inventoryHandler->saveChamberStageChange($chamber->id,'Stage-0',Carbon::now()->setTimezone('Asia/Dhaka'));
                    }
                 }else throw new \Exception('Loading amount limit exceed.');

                $newUnloading =new Unloading();

                $newUnloading->booking_id = $booking_id;
                $newUnloading->delivery_id = $delivery_id;
                $newUnloading->loaddistribution_id = $unloading['loaddistribution_id'];
                $newUnloading->potato_type = $unloading['potato_type'];
                $newUnloading->quantity = $unloading['quantity'];
                $newUnloading->bag_no = $unloading['bag_no'];
                $newUnloading->save();

            }
        }catch (\Exception $e){
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $newUnloading;
    }

    private function checkVisibility($a,$b){
        if($a-$b <0){
            return false;
        }
        else return true;
    }
}
