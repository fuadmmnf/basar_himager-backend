<?php

namespace App\Repositories;

use App\Handlers\InventoryHandler;
use App\Models\Inventory;
use App\Models\Loaddistribution;
use App\Models\Receive;
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
            $booking = $request['booking_id'];

            $inventories = Inventory::where('id', $compartment)->first();
            $floor = Inventory::where('id',$inventories->parent_id)->first();
            $chamber = Inventory::where('id',$floor->parent_id)->first();

            foreach ($request['distributions'] as $distribution){
                $newLoaddistribution=new Loaddistribution();

                $newLoaddistribution->booking_id = $booking;
                $newLoaddistribution->receive_id = $id;
                $newLoaddistribution->compartment_id = $compartment;
                $newLoaddistribution->potato_type = $distribution['potato_type'];
                $newLoaddistribution->quantity = $distribution['quantity'];
                $newLoaddistribution->bag_no = $distribution['bag_no'];
                $newLoaddistribution->current_quantity = $distribution['quantity'];
                $newLoaddistribution->save();

                $receiveItem = Receiveitem::where('receive_id',$id)->where('potatoe_type',$distribution['potato_type'])->first();
                $receiveItem->loaded_quantity = $receiveItem->loaded_quantity + $distribution['quantity'];
                if($receiveItem->loaded_quantity > $receiveItem->quantity)
                {
                    throw new \Exception('Loading amount limit exceed.');
                }
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
        $inventoryHandler = new InventoryHandler();

        $loaddistributions = Loaddistribution::orderByDesc('created_at')->where('receive_id',$receive_id)->get();
        foreach ($loaddistributions as $loaddistribution){
            $loaddistribution->inventory = $inventoryHandler->fetchFullInventoryWithParentBYId($loaddistribution->compartment_id);
        }
        $loaddistributions->receive_info = Receive::where('id',$receive_id)
            ->select('receiving_no')
            ->first();
        return $loaddistributions;
    }


    public function getLoadDistrbutionByBooking_id($booking_id){
        $inventoryHandler = new InventoryHandler();

        $loads = Loaddistribution::where('booking_id',$booking_id)->get();
        foreach($loads as $load){
            $load->inventory = $inventoryHandler->fetchFullInventoryWithParentBYId($load->compartment_id);
        }
        return $loads;
    }
}
