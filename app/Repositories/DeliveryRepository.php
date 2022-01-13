<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\Delivery;
use App\Models\Deliverygroup;
use App\Models\Deliveryitem;
use App\Models\Gatepass;
use App\Models\Loancollection;
use App\Models\Loandisbursement;
use App\Models\Unloading;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeliveryRepository implements DeliveryRepositoryInterface
{


    public function getRecentDeliveries()
    {
        $deliveries = Delivery::orderBy('created_at')
            ->with('booking')
            ->with('booking.client')
            ->with('deliveryitems')
            ->with('unloading')
            ->paginate(20);
        return $deliveries;
    }

    public function getRecentDeliveryGroups(){
        $deliveryGroups = Deliverygroup::orderByDesc('delivery_time')
            ->paginate(20);
        $deliveryGroups->load('gatepasses', 'deliveries', 'deliveries.booking', 'deliveries.booking.client');
        return $deliveryGroups;
    }

    public function fetchDeliveriesByGroupId($deliverygroup_id)
    {
        $deliveries = Delivery::where('deliverygroup_id', $deliverygroup_id)
            ->with('booking')
            ->with('booking.client')
            ->with('deliveryitems')
            ->with('deliveryitems.unloadings')
            ->with('deliverygroup')
            ->get();
        return $deliveries;
    }

    public function getPaginatedDeliveriesByBookingId($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $deliveries =Delivery::where('booking_id', $booking->id)
        ->with('deliverygroup')
        ->paginate(15);

        return $deliveries;
    }

    private function validateDeliveryQuantity($receiveItems, $deliveryItems)
    {
        $receivesLeft = [];
        foreach ($receiveItems as $receiveItem) {
            if (isset($receivesLeft[$receiveItem->potato_type])) {
                $receivesLeft[$receiveItem->potato_type] += $receiveItem->quantity_left;
            } else {
                $receivesLeft[$receiveItem->potato_type] = $receiveItem->quantity_left;
            }
        }

        $deliveryQuantities = [];
        foreach ($deliveryItems as $deliveryItem) {
            if (isset($deliveryQuantities[$deliveryItem['potato_type']])) {
                $deliveryQuantities[$deliveryItem['potato_type']] += $deliveryItem['quantity'];
            } else {
                $deliveryQuantities[$deliveryItem['potato_type']] = $deliveryItem['quantity'];
            }
        }

        foreach ($deliveryQuantities as $key => $value) {
            if (!isset($receivesLeft[$key]) || $receivesLeft[$key] < $value) {
                return false;
            }
        }

        return true;
    }

    private function createDelivery(Deliverygroup $deliverygroup, array $deliveryRequest)
    {
        $booking = Booking::findOrFail($deliveryRequest['booking_id']);
        if (!$this->validateDeliveryQuantity($booking->receiveitems, $deliveryRequest['deliveryitems'])) {
            return null;
        }
        $totalQuantity = 0;
        foreach ($deliveryRequest['deliveryitems'] as $deliveryitem) {
            $totalQuantity += $deliveryitem['quantity'];
        }

        $newDelivery = new Delivery();
        $newDelivery->deliverygroup_id = $deliverygroup->id;
        $newDelivery->booking_id = $booking->id;
        $newDelivery->cost_per_bag = $deliveryRequest['cost_per_bag'];
//        $newDelivery->quantity_bags_fanned = $deliveryRequest['quantity_bags_fanned'];
//        $newDelivery->fancost_per_bag = $deliveryRequest['fancost_per_bag'];
        $newDelivery->do_charge = $deliveryRequest['do_charge'];
//        $newDelivery->total_charge = ($newDelivery->quantity_bags_fanned * $newDelivery->fancost_per_bag) + ($totalQuantity * ($newDelivery->cost_per_bag + $newDelivery->do_charge));
        $newDelivery->total_charge = $totalQuantity * ($newDelivery->cost_per_bag + $newDelivery->do_charge);

        if ($booking->bags_out + $totalQuantity > $booking->bags_in) {
            throw new \Exception('total amount greater than bags received');
        }
        $newDelivery->bags_currently_remaining = $booking->bags_in - $booking->bags_out - $totalQuantity;
        if ($newDelivery->total_charge <= $booking->booking_amount) {
            $newDelivery->charge_from_booking_amount = $newDelivery->total_charge;
            $booking->booking_amount = $booking->booking_amount - $newDelivery->total_charge;
            //$newDelivery->total_charge = 0;
        } else {
            $newDelivery->charge_from_booking_amount = $booking->booking_amount;
            // $newDelivery->total_charge = $newDelivery->total_charge - $booking->booking_amount;
            $booking->booking_amount = 0;
        }

        $booking->bags_out = $booking->bags_out + $totalQuantity;

        $booking->save();
        $newDelivery->save();

        $receiveitems = $booking->receiveitems;
        foreach ($deliveryRequest['deliveryitems'] as $deliveryitem) {
            $newDeliveyItem = new Deliveryitem();
            $newDeliveyItem->delivery_id = $newDelivery->id;
            $newDeliveyItem->quantity = $deliveryitem['quantity'];
            $newDeliveyItem->potato_type = $deliveryitem['potato_type'];
            $newDeliveyItem->srlot_no = $deliveryitem['srlot_no'];
            $newDeliveyItem->save();

            $quantity = $newDeliveyItem->quantity;
            foreach ($receiveitems as $receiveitem) {
                if ($receiveitem->quantity_left > 0 &&
                    $receiveitem->potato_type == $newDeliveyItem->potato_type &&
                    $quantity > 0) {
                    $used = min($quantity, $receiveitem->quantity_left);
                    $receiveitem->quantity_left = $receiveitem->quantity_left - $used;
                    $receiveitem->save();

                    $quantity -= $used;
                }
            }
        }


        return $newDelivery;
    }

    public function saveLoancollection(Deliverygroup $deliverygroup,array $request)
    {
        $loandisbursement = Loandisbursement::findOrFail($request['loandisbursement_id']);

        error_log($loandisbursement);
        if($loandisbursement->amount_left < $request['payment_amount']){
            return null;
        }
        error_log($deliverygroup);

        $newLoancollection = new Loancollection();
        $newLoancollection->loandisbursement_id = $loandisbursement->id;
        $newLoancollection->deliverygroup_id = $deliverygroup->id;
        $newLoancollection->loancollection_no = Str::random(8);
        $newLoancollection->surcharge = $request['surcharge'];
        $newLoancollection->service_charge_rate = $request['service_charge_rate'];
        $newLoancollection->payment_amount = $request['payment_amount'];
        $newLoancollection->pending_loan_amount = $request['pending_loan_amount'];
        $newLoancollection->payment_date = Carbon::parse($request['payment_date'])->setTimezone('Asia/Dhaka');
        $newLoancollection->save();

        $loandisbursement->amount_left = $loandisbursement->amount_left - $newLoancollection->payment_amount;
        $loandisbursement->save();

        return $newLoancollection;
    }

    public function saveDeliverygroup(array $request)
    {
        DB::beginTransaction();
        try {
            $bookingnoArr = array_column($request['deliveries'], 'booking_no');
            if(count($bookingnoArr) != 1 && count($bookingnoArr) != count(array_unique($bookingnoArr))){
                throw new \Exception('duplicate booking no. exists');
            }

            $newDeliverygroup = new Deliverygroup();
            $newDeliverygroup->delivery_time = Carbon::parse($request['delivery_time'])->setTimezone('Asia/Dhaka');
            $newDeliverygroup->delivery_no = sprintf('%04d', Deliverygroup::whereYear('delivery_time', $newDeliverygroup->delivery_time)->count() + 1) . $newDeliverygroup->delivery_time->year % 100;
            $newDeliverygroup->save();

            foreach ($request['deliveries'] as $deliveryRequest) {
                $this->createDelivery($newDeliverygroup, $deliveryRequest);
                foreach ($deliveryRequest['loancollections'] as $loancollection) {
                    $this->saveLoancollection($newDeliverygroup, $loancollection);
                    error_log($loancollection['payment_amount']);
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

        DB::commit();
        return $newDeliverygroup;
    }


    public function getGatepassDetails($gatepass_no)
    {
        $gatepass = Gatepass::where('gatepass_no', $gatepass_no)->firstOrFail();
        $gatepass->load('receive', 'receive.booking');
        return $gatepass;
    }

    public function saveGatepass(array $request)
    {
        $deliverygroup = Deliverygroup::findOrFail($request['deliverygroup_id']);
        $newGatepass = new Gatepass();
        $newGatepass->deliverygroup_id = $deliverygroup->id;
        $newGatepass->gatepass_time = Carbon::parse($request['gatepass_time'])->setTimezone('Asia/Dhaka');
        $newGatepass->gatepass_no = sprintf('%04d', Gatepass::whereYear('gatepass_time', $newGatepass->gatepass_time)->count()) . $newGatepass->gatepass_time->year % 100;
        $newGatepass->transport = $request['transport'];
        $newGatepass->save();

        return $newGatepass;
    }


}
