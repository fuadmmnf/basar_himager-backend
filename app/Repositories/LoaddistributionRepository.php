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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class LoaddistributionRepository implements LoaddistributionRepositoryInterface
{


    public function saveLoaddistrbution(array $request)
    {
        DB::beginTransaction();
        try {
            $receive = Receive::findOrFail($request['receive_id']);

            if (count($receive->receiveitems) != count($request['loadings'])) {
                throw new \Exception('loading must be done for all items');
            }

            foreach ($request['loadings'] as $loading) {


                $receiveItem = Receiveitem::where('id', $loading['receiveitem_id'])->first();

                $totalReceiveitemLoaded = 0;
                foreach ($loading['distributions'] as $distribution) {
                    $totalReceiveitemLoaded += $distribution['quantity'];
                }
                if ($totalReceiveitemLoaded != $receiveItem->quantity) {
                    throw new \Exception('loading must be done for all bags');
                }


                foreach ($loading['distributions'] as $distribution) {
                    $compartment = Inventory::findOrFail($distribution['compartment_id']);

                    $newLoaddistribution = new Loaddistribution();
                    $newLoaddistribution->booking_id = $request['booking_id'];
                    $newLoaddistribution->receive_id = $receive->id;
                    $newLoaddistribution->receiveitem_id = $loading['receiveitem_id'];
                    $newLoaddistribution->compartment_id = $distribution['compartment_id'];
                    $newLoaddistribution->palot_status = 'load';
                    $newLoaddistribution->potato_type = $receiveItem->potato_type;
                    $newLoaddistribution->quantity = $distribution['quantity'];
                    $newLoaddistribution->current_quantity = $distribution['quantity'];
                    $newLoaddistribution->save();

//                    $receiveItem->loaded_quantity = $receiveItem->loaded_quantity + $distribution['quantity'];

                    $floor = Inventory::where('id', $compartment->parent_id)->first();
                    $chamber = Inventory::where('id', $floor->parent_id)->first();

                    $compartment->current_quantity = $compartment->current_quantity + $distribution['quantity'];
                    $compartment->save();
                    $floor->current_quantity = $floor->current_quantity + $distribution['quantity'];
                    $floor->save();
                    $chamber->current_quantity = $chamber->current_quantity + $distribution['quantity'];
                    $chamber->save();

                }
                $receiveItem->loaded_quantity += $totalReceiveitemLoaded;
                $receiveItem->save();

            }
            $receive->status = 1;
            $receive->palot_status = 'load';
            $receive->save();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $newLoaddistribution;
    }

    public function savePalot(array $request)
    {
        DB::beginTransaction();
        try {
            $receive = Receive::findOrFail($request['receive_id']);
            foreach ($request['loaddistributions'] as $loaddistribution) {
                $previousLoaddistribution = Loaddistribution::where('id', $loaddistribution['loaddistribution_id'])->where('receive_id', $receive->id)->firstOrFail();
                $previousCompartment = Inventory::findOrFail($previousLoaddistribution['compartment_id']);
                $previousFloor = Inventory::where('id', $previousCompartment->parent_id)->first();
                $previousChamber = Inventory::where('id', $previousFloor->parent_id)->first();

                $totalItemPalotted = 0;
                foreach ($loaddistribution['distributions'] as $distribution) {
                    $totalItemPalotted += $distribution['quantity'];
                }
                if ($totalItemPalotted != $previousLoaddistribution->quantity) {
                    throw new \Exception('loading must be done for all available bags only');
                }
                $previousCompartment->current_quantity = $previousCompartment->current_quantity - $totalItemPalotted;
                $previousCompartment->save();
                $previousFloor->current_quantity = $previousFloor->current_quantity - $totalItemPalotted;
                $previousFloor->save();
                $previousChamber->current_quantity = $previousChamber->current_quantity - $totalItemPalotted;
                $previousChamber->save();


                foreach ($loaddistribution['distributions'] as $distribution) {


                    $compartment = Inventory::findOrFail($distribution['compartment_id']);

                    $newLoaddistribution = new Loaddistribution();
                    $newLoaddistribution->booking_id = $previousLoaddistribution->booking_id;
                    $newLoaddistribution->receive_id = $previousLoaddistribution->receive_id;
                    $newLoaddistribution->receiveitem_id = $previousLoaddistribution->receiveitem_id;
                    $newLoaddistribution->compartment_id = $distribution['compartment_id'];
                    $newLoaddistribution->palot_status = $request['palot_status'];
                    $newLoaddistribution->potato_type = $previousLoaddistribution->potato_type;
                    $newLoaddistribution->quantity = $distribution['quantity'];
                    $newLoaddistribution->current_quantity = $distribution['quantity'];
                    $newLoaddistribution->save();


                    $floor = Inventory::where('id', $compartment->parent_id)->first();
                    $chamber = Inventory::where('id', $floor->parent_id)->first();

                    $compartment->current_quantity = $compartment->current_quantity + $distribution['quantity'];
                    $compartment->save();
                    $floor->current_quantity = $floor->current_quantity + $distribution['quantity'];
                    $floor->save();
                    $chamber->current_quantity = $chamber->current_quantity + $distribution['quantity'];
                    $chamber->save();


                }
                $previousLoaddistribution->current_quantity = 0;
                $previousLoaddistribution->save();


            }
            $receive->palot_status = $request['palot_status'];
            $receive->save();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $newLoaddistribution;
    }


    public function getLoadDistributionsByReceive($receive_group_id)
    {

        $receives = Receive::where('receivegroup_id', $receive_group_id)->with('booking')->with('booking.client')->with('receivegroup')->get();
        foreach ($receives as $receive) {
            $receive->loaddistributions = Loaddistribution::where('receive_id', $receive->id)->get();
            $inventoryHandler = new InventoryHandler();
            foreach ($receive->loaddistributions as $loaddistribution) {
                $loaddistribution->inventory = $inventoryHandler->fetchFullInventoryWithParentById($loaddistribution->compartment_id);
            }
        }
        return $receives;
    }

    public function getLoadDistributionsByReceiveID($receive_id)
    {

        $loaddistributions = Loaddistribution::where('receive_id', $receive_id)->get();

        $inventoryHandler = new InventoryHandler();
        foreach ($loaddistributions as $loaddistribution) {
            $loaddistribution->inventory = $inventoryHandler->fetchFullInventoryWithParentById($loaddistribution->compartment_id);
        }

        return $loaddistributions;
    }

    public function getLoadDistributionDatesByClient($client_id)
    {
        $bookingIds = Booking::where('client_id', $client_id)->pluck('id');
        $loaddistributionDates = Loaddistribution::whereIn('booking_id', $bookingIds)
            ->select(DB::raw('DATE(created_at) as date'))
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date');
        return $loaddistributionDates;
    }

    public function getLoadPositionsByBooking($booking_id)
    {
        $loads = Loaddistribution::where('booking_id', $booking_id)->where('current_quantity', '>', 0)->get();
        foreach ($loads as $load) {
            $load->inventory = $load->inventory_tree;
            $load->lot_no = $load->receive->lot_no;
        }
        return $loads;
    }
}
