<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\Receive;
use App\Models\Receiveitem;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;
use Carbon\Carbon;

class ReceiveRepository implements ReceiveRepositoryInterface
{

    public function getReceiveDetails($receive_no)
    {
        $receive = Receive::where('receiving_no', $receive_no)->firstOrFail();
        $receive->load('booking', 'booking.client');
        return $receive;
    }

    public function getReceiveById($id)
    {
        // TODO: Implement getReceiveById() method.
        $receive = Receive::where('id', $id)
            ->with('booking')
            ->with('booking.client')
            ->with('receiveitems')->first();
        return $receive;
    }

    public function getRecentReceives()
    {
        $receives = Receive::orderByDesc('receiving_time')
            ->with('booking')
            ->with('booking.client')
            ->with('receiveitems')
            ->paginate(20);
        return $receives;
    }


    public function saveReceive(array $request)
    {
        $booking = Booking::findOrFail($request['booking_id']);
        $newReceive = new Receive();
        $newReceive->booking_id = $booking->id;

        $totalQuantity = 0;

        $receiveitems = [];
        foreach ($request['receiveitems'] as $receiveitem){
            if(isset($receiveitems[$receiveitem['potatoe_type']])){
                $receiveitems[$receiveitem['potatoe_type']] += $receiveitem['quantity'];
            } else {
                $receiveitems[$receiveitem['potatoe_type']] = $receiveitem['quantity'];
            }
            $totalQuantity += $receiveitem['quantity'];
        }

        if ($booking->bags_in + $totalQuantity > $booking->quantity) {
            return null;
        }

        $newReceive->receiving_time = Carbon::parse($request['receiving_time'])->setTimezone('Asia/Dhaka');
        $newReceive->receiving_no = sprintf('%04d', Receive::whereYear('receiving_time', $newReceive->receiving_time)->count()) . $newReceive->receiving_time->year % 100;
        $newReceive->transport = $request['transport'];

        $newReceive->save();

        foreach ($receiveitems as $potatoe_type => $quantity) {
            $newReceiveItem = new Receiveitem();
            $newReceiveItem->receive_id = $newReceive->id;
            $newReceiveItem->quantity = $quantity;
            $newReceiveItem->quantity_left = $newReceiveItem->quantity;
            $newReceiveItem->potatoe_type = $potatoe_type;
            $newReceiveItem->save();
        }


        $booking->bags_in = $booking->bags_in + $totalQuantity;
        $booking->save();

        return $newReceive;
    }

}
