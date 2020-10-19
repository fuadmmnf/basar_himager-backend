<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\Receive;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;
use Carbon\Carbon;

class ReceiveRepository implements ReceiveRepositoryInterface
{
    public function getRecentReceives()
    {
        $receives = Receive::orderBy('receiving_time')->paginate(20);
        $receives->load('booking:booking_no', 'booking.client');
        return $receives;
    }


    public function saveReceive(array $request)
    {
        $booking = Booking::findOrFail($request['booking_id']);
        $newReceive = new Receive();
        $newReceive->booking_id = $booking->id;
        $newReceive->receiving_no = substr(md5($request['booking_id']),0,8);
        $newReceive->receiving_time = Carbon::parse($request['receiving_time']);
        $newReceive->quantity = $request['quantity'];
        $newReceive->potatoe_type = $request['potatoe_type'];
        $newReceive->transport_type = $request['transport_type'];

        $newReceive->save();

        $booking->bags_in = $booking->bags_in + $newReceive->quantity;
        $booking->save();

        return $newReceive;
    }
}
