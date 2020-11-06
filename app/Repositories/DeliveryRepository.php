<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\Delivery;
use App\Models\Deliveryitem;
use App\Models\Gatepass;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use Carbon\Carbon;

class DeliveryRepository implements DeliveryRepositoryInterface
{


    public function getRecentDeliveries()
    {
        $deliveries = Delivery::orderBy('delivery_time')
            ->with('booking')
            ->with('booking.client')
            ->with('gatepasses')
            ->with('deliveryitems')
            ->paginate(20);
        return $deliveries;
    }


    public function saveDelivery(array $request)
    {
        $booking = Booking::findOrFail($request['booking_id']);
        $newDelivery = new Delivery();
        $newDelivery->booking_id = $booking->id;
        $newDelivery->delivery_time = Carbon::parse($request['delivery_time']);
        $newDelivery->delivery_no = sprintf('%04d', Delivery::whereYear('delivery_time', $newDelivery->delivery_time)->count()) . $newDelivery->delivery_time->year % 100;
        $newDelivery->cost_per_bag = $request['cost_per_bag'];
        $newDelivery->quantity_bags_fanned = $request['quantity_bags_fanned'];
        $newDelivery->fancost_per_bag = $request['fancost_per_bag'];
        $newDelivery->due_charge = $request['due_charge'];
        $newDelivery->total_charge = ($newDelivery->quantity_bags_fanned * $newDelivery->fancost_per_bag) + $newDelivery->due_charge;

        $newDelivery->save();

        $totalQuantity = 0;
        foreach ($request['deliveryitems'] as $deliveryitem){
            $newDeliveyItem = new Deliveryitem();
            $newDeliveyItem->receive_id = $newDelivery->id;
            $newDeliveyItem->quantity = $deliveryitem['quantity'];
            $newDeliveyItem->potatoe_type = $deliveryitem['potatoe_type'];
            $newDeliveyItem->save();

            $totalQuantity += $newDeliveyItem->quantity;
        }

        $newDelivery->total_charge = $newDelivery->total_charge + ($totalQuantity * $newDelivery->cost_per_bag);
        $newDelivery->save();

        $booking->bags_out = $booking->bags_out + $newDelivery->quantity_bags;
        $booking->save();

        return $newDelivery;
    }


    public function getGatepassDetails($gatepass_no)
    {
        $gatepass = Gatepass::where('gatepass_no', $gatepass_no)->firstOrFail();
        $gatepass->load('receive', 'receive.booking');
        return $gatepass;
    }

    public function saveGatepass(array $request)
    {
        $delivery = Delivery::findOrFail($request['delivery_id']);
        $newGatepass = new Gatepass();
        $newGatepass->delivery_id = $delivery->id;
        $newGatepass->gatepass_time = Carbon::parse($request['gatepass_time']);
        $newGatepass->gatepass_no = sprintf('%04d', Gatepass::whereYear('gatepass_time', $newGatepass->gatepass_time)->count()) . $newGatepass->gatepass_time->year % 100;
        $newGatepass->transport = $request['transport'];
        $newGatepass->save();

        return $newGatepass;
    }


}
