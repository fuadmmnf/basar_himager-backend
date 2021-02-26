<?php


namespace App\Repositories;


use App\Handlers\InventoryHandler;
use App\Models\Chamber;
use App\Models\Chamberentry;
use App\Models\Delivery;
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
        try {
            $booking_id = $request['booking_id'];
            $delivery= Delivery::find($request['delivery_id']);
//            $deliveryItems = Deliveryitem::where('delivery_id', $delivery_id)->get();


            foreach ($request['unloadings'] as $unloading) {
                $deliveryitem = Deliveryitem::find($unloading['deliveryitem_id']);

                $totalUnloadingQuantity = 0;
                foreach ($unloading['loadings'] as $loading) {
                    $totalUnloadingQuantity += $loading['quantity'];
                }
                if ($totalUnloadingQuantity != $deliveryitem->quantity) {
                    throw new \Exception('Loading amount limit exceed.');
                }

                foreach ($unloading['loadings'] as $loading) {
                    $loaddistribution = Loaddistribution::where('id', $loading['loaddistribution_id'])->first();


                    $compartment_id = $loaddistribution->compartment_id;
                    $loaddistribution->current_quantity -= $loading['quantity'];
                    $loaddistribution->save();


                    $compartment = Inventory::where('id', $compartment_id)->first();
                    $floor = Inventory::where('id', $compartment->parent_id)->first();
                    $chamber = Inventory::where('id', $floor->parent_id)->first();

                    if ($compartment->current_quantity < $loading['quantity']) {
                        throw new \Exception('compartment limit exceeded');
                    }

                    $compartment->current_quantity = $compartment->current_quantity - $loading['quantity'];
                    $compartment->save();

                    $floor->current_quantity = $floor->current_quantity - $loading['quantity'];
                    $floor->save();

                    $chamber->current_quantity = $chamber->current_quantity - $loading['quantity'];
                    $chamber->save();

                    if ($chamber->current_quantity == 0) {
                        //$chamberStage->stage = 'Stage-0';
                        $inventoryHandler = new InventoryHandler();
                        $inventoryHandler->saveChamberStageChange($chamber->id, 'Stage-0', Carbon::now()->setTimezone('Asia/Dhaka'));
                    }

                    $newUnloading = new Unloading();
                    $newUnloading->booking_id = $booking_id;
                    $newUnloading->deliveryitem_id = $unloading['deliveryitem_id'];
                    $newUnloading->loaddistribution_id = $loaddistribution->id;
                    $newUnloading->potato_type = $deliveryitem->potato_type;
                    $newUnloading->quantity = $deliveryitem->quantity;
//                $newUnloading->bag_no = $unloading['bag_no'];
                    $newUnloading->save();
                }
            }
            $delivery->status = 1;
            $delivery->save();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $newUnloading;
    }

}
