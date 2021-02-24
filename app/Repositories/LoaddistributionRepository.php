<?php

namespace App\Repositories;

use App\Handlers\InventoryHandler;
use App\Models\Booking;
use App\Models\Inventory;
use App\Models\Loaddistribution;
use App\Models\Receive;
use App\Models\Receiveitem;
use App\Models\settings;
use App\Repositories\Interfaces\LoaddistributionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class LoaddistributionRepository implements LoaddistributionRepositoryInterface
{


    public function saveLoaddistrbution(array $request)
    {
        // TODO: Implement saveLoaddistrbution() method.

//        DB::beginTransaction();
//        try{

//            $id = $request['receive_id'];
//            $compartment = $request['compartment_id'];
//            $booking = $request['booking_id'];
//
//            $inventories = Inventory::where('id', $compartment)->first();
//            $floor = Inventory::where('id',$inventories->parent_id)->first();
//            $chamber = Inventory::where('id',$floor->parent_id)->first();

            foreach ($request['loadings'] as $loading){

                $receiveItem = Receiveitem::where('id', $loading['receiveitem_id'])->first();

                foreach ($loading['distributions'] as $distribution) {

                    $newLoaddistribution = new Loaddistribution();
                    $newLoaddistribution->booking_id = $request['booking_id'];
                    $newLoaddistribution->receive_id = $request['receive_id'];
                    $newLoaddistribution->receiveitem_id = $loading['receiveitem_id'];
                    $newLoaddistribution->compartment_id = $distribution['compartment_id'];
                    $newLoaddistribution->potato_type = $receiveItem->potato_type;
                    $newLoaddistribution->quantity = $distribution['quantity'];
                    $newLoaddistribution->current_quantity = $distribution['quantity'];

                    $newLoaddistribution->save();

                    $receiveItem->loaded_quantity = $receiveItem->loaded_quantity + $distribution['quantity'];
                    if($receiveItem->loaded_quantity > $receiveItem->quantity)
                    {
                        throw new \Exception('Loading amount limit exceed.');
                    }
                    $receiveItem->save();

                    $inventory = Inventory::where('id', $distribution->compartment_id)->first();
                    $floor = Inventory::where('id',$inventory->parent_id)->first();
                    $chamber = Inventory::where('id',$floor->parent_id)->first();

                    $inventory->current_quantity = $inventory->current_quantity + $distribution['quantity'];
                    $inventory->save();
                    $floor->current_quantity = $floor->current_quantity + $distribution['quantity'];
                    $floor->save();
                    $chamber->current_quantity = $chamber->current_quantity + $distribution['quantity'];
                    $chamber->save();

                }
//                $setting = settings::where('key','current_bag_no')->first();
//
//                $newLoaddistribution=new Loaddistribution();
//
//                $newLoaddistribution->booking_id = $booking;
//                $newLoaddistribution->receive_id = $id;
//                $newLoaddistribution->compartment_id = $compartment;
//                $newLoaddistribution->potato_type = $distribution['potato_type'];
//                $newLoaddistribution->quantity = $distribution['quantity'];
//                $newLoaddistribution->bag_no = ($setting->value+1)." to ".($setting->value+$distribution['quantity']);
//                $setting->value = $setting->value+$distribution['quantity'];
//                $setting->save();
//                $newLoaddistribution->current_quantity = $distribution['quantity'];
//                $newLoaddistribution->save();
//
//                $receiveItem = Receiveitem::where('receive_id',$id)->where('potato_type',$distribution['potato_type'])->first();
//                $receiveItem->loaded_quantity = $receiveItem->loaded_quantity + $distribution['quantity'];
//                if($receiveItem->loaded_quantity > $receiveItem->quantity)
//                {
//                    throw new \Exception('Loading amount limit exceed.');
//                }
//                $receiveItem->save();
//
//                $inventories->current_quantity = $inventories->current_quantity + $distribution['quantity'];
//                $inventories->save();
//                $floor->current_quantity = $floor->current_quantity + $distribution['quantity'];
//                $floor->save();
//                $chamber->current_quantity = $chamber->current_quantity + $distribution['quantity'];
//                $chamber->save();
            }
//        }catch (\Exception $e){
//            DB::rollback();
//            throw new \Exception($e->getMessage());
//        }
//        DB::commit();

        return $newLoaddistribution;
    }

    public function getLoadDistributionsByReceive($receive_group_id){

        $receives = Receive::where('receivegroup_id',$receive_group_id)->with('booking')->with('receivegroup')->get();
        foreach ($receives as $receive ){
            $receive->loaddistributions = Loaddistribution::where('receive_id',$receive->id)->get();
            $inventoryHandler = new InventoryHandler();
            foreach ($receive->loaddistributions as $loaddistribution){
                $loaddistribution->inventory = $inventoryHandler->fetchFullInventoryWithParentById($loaddistribution->compartment_id);
            }
        }
        return $receives;
    }

    public function getLoadDistributionsByReceiveID($receive_id){

        $loaddistributions = Loaddistribution::where('receive_id',$receive_id)->get();

            $inventoryHandler = new InventoryHandler();
            foreach ($loaddistributions as $loaddistribution){
                $loaddistribution->inventory = $inventoryHandler->fetchFullInventoryWithParentById($loaddistribution->compartment_id);
            }

        return $loaddistributions;
    }

    public function getLoadDistributionDatesByClient($client_id){
        $bookingIds = Booking::where('client_id', $client_id)->pluck('id');
        $loaddistributionDates = Loaddistribution::whereIn('booking_id', $bookingIds)
                    ->select(DB::raw('DATE(created_at) as date'))
                    ->distinct()
                    ->orderBy('date','desc')
                    ->pluck('date');
        return $loaddistributionDates;
    }

    public function getLoadDistrbutionByBooking($booking_id){
        $loads = Loaddistribution::where('booking_id',$booking_id)->get();
        $inventoryHandler = new InventoryHandler();
        foreach($loads as $load){
            $load->inventory = $inventoryHandler->fetchFullInventoryWithParentById($load->compartment_id);
        }
        return $loads;
    }
}
