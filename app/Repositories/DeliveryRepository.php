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

    private function validateDeliveryQuantity($receiveItems, $deliveryItems)
    {
        $receivesLeft = [];
        foreach ($receiveItems as $receiveItem) {
            if (isset($receivesLeft[$receiveItem->potatoe_type])) {
                $receivesLeft[$receiveItem->potatoe_type] += $receiveItem->quantity_left;
            } else {
                $receivesLeft[$receiveItem->potatoe_type] = $receiveItem->quantity_left;
            }
        }

        $deliveryQuantities = [];
        foreach ($deliveryItems as $deliveryItem) {
            if (isset($deliveryQuantities[$deliveryItem->potatoe_type])) {
                $deliveryQuantities[$deliveryItem['potatoe_type']] += $deliveryItem['quantity'];
            } else {
                $deliveryQuantities[$deliveryItem->potatoe_type] = $deliveryItem->quantity_left;
            }
        }

        foreach ($deliveryQuantities as $key => $value) {
            if (!isset($receivesLeft[$key]) || $receivesLeft[$key] < $value) {
                return false;
            }
        }

        return true;
    }

    public function saveDelivery(array $request)
    {
        $booking = Booking::findOrFail($request['booking_id']);

        if (!$this->validateDeliveryQuantity($booking->receiveitems, $request['deliveryitems'])) {
            return null;
        }

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
        $receiveitems = $booking->receiveitems;
        foreach ($request['deliveryitems'] as $deliveryitem) {
            $newDeliveyItem = new Deliveryitem();
            $newDeliveyItem->delivery_id = $newDelivery->id;
            $newDeliveyItem->quantity = $deliveryitem['quantity'];
            $newDeliveyItem->potatoe_type = $deliveryitem['potatoe_type'];
            $newDeliveyItem->save();
            $totalQuantity += $newDeliveyItem->quantity;

            $quantity = $newDeliveyItem->quantity;
            foreach ($receiveitems as $receiveitem) {
                if ($receiveitem->quantity_left > 0 &&
                    $receiveitem->potatoe_type == $newDeliveyItem->potatoe_type &&
                    $quantity > 0) {
                    $used = min($quantity, $receiveitem->quantity_left);
                    $receiveitem->quantity_left = $receiveitem->quantity_left - $used;
                    $receiveitem->save();

                    $quantity -= $used;
                }
            }

        }

        $newDelivery->total_charge = $newDelivery->total_charge + ($totalQuantity * $newDelivery->cost_per_bag);
        $newDelivery->save();

        $booking->bags_out = $booking->bags_out + $totalQuantity;
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
