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

    public function getRecentReceives()
    {
        $receives = Receive::orderBy('receiving_time')
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
        $newReceive->receiving_time = Carbon::parse($request['receiving_time']);
        $newReceive->receiving_no = sprintf('%04d', Receive::whereYear('receiving_time', $newReceive->receiving_time)->count()) . $newReceive->receiving_time->year % 100;

        $newReceive->transport = $request['transport'];

        $newReceive->save();


        foreach ($request['receiveitems'] as $receiveitem){
            $newReceiveItem = new Receiveitem();
            $newReceiveItem->receive_id = $newReceive->id;
            $newReceiveItem->quantity = $receiveitem['quantity'];
            $newReceiveItem->quantity_left = $newReceiveItem->quantity;
            $newReceiveItem->potatoe_type = $receiveitem['potatoe_type'];
            $newReceiveItem->save();
        }


        $booking->bags_in = $booking->bags_in + $newReceive->quantity;
        $booking->save();

        return $newReceive;
    }
}
