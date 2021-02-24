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

        DB::beginTransaction();
        try{

            foreach ($request['loadings'] as $loading){

                error_log("1");
                $receiveItem = Receiveitem::where('id', $loading['receiveitem_id'])->first();
                error_log("2");

                foreach ($loading['distributions'] as $distribution) {

                    $newLoaddistribution = new Loaddistribution();
                    error_log("3");

                    $newLoaddistribution->booking_id = $request['booking_id'];
                    error_log("4");

                    $newLoaddistribution->receive_id = $request['receive_id'];
                    error_log("5");

                    $newLoaddistribution->receiveitem_id = $loading['receiveitem_id'];
                    error_log("6");

                    $newLoaddistribution->compartment_id = $distribution['compartment_id'];
                    error_log("7");

                    $newLoaddistribution->potato_type = $receiveItem->potato_type;
                    error_log("8");

                    $newLoaddistribution->quantity = $distribution['quantity'];
                    error_log("9");

                    $newLoaddistribution->current_quantity = $distribution['quantity'];
                    error_log("10");


                    $newLoaddistribution->save();
                    error_log("1iixjb1");
                    $receiveItem->loaded_quantity = $receiveItem->loaded_quantity + $distribution['quantity'];
                    error_log("11");

                    if($receiveItem->loaded_quantity > $receiveItem->quantity)
                    {
                        throw new \Exception('Loading amount limit exceed.');
                    }
                    $receiveItem->save();

                    $inventory = Inventory::where('id', $distribution['compartment_id'])->first();
                    error_log("12");

                    $floor = Inventory::where('id',$inventory->parent_id)->first();
                    error_log("13");

                    $chamber = Inventory::where('id',$floor->parent_id)->first();
                    error_log("14");


                    $inventory->current_quantity = $inventory->current_quantity + $distribution['quantity'];
                    error_log("15");

                    $inventory->save();
                    $floor->current_quantity = $floor->current_quantity + $distribution['quantity'];
                    error_log("16");

                    $floor->save();
                    $chamber->current_quantity = $chamber->current_quantity + $distribution['quantity'];
                    error_log("17");

                    $chamber->save();

                }
            }
        }catch (\Exception $e){
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

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
