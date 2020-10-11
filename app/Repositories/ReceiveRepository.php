<?php


namespace App\Repositories;

use App\Models\Receive;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;
use Carbon\Carbon;

class ReceiveRepository implements ReceiveRepositoryInterface
{

    public function saveReceive(array $request)
    {
        $newReceive = new Receive();

        $newReceive->booking_id = $request['booking_id'];
        $newReceive->receiving_no = substr(md5($request['booking_id']),0,8);
        $newReceive->receiving_time = Carbon::parse($request['receiving_time']);
        $newReceive->quantity = $request['quantity'];
        $newReceive->potatoe_type = $request['potatoe_type'];
        $newReceive->transport_type = $request['transport_type'];

        $newReceive->save();

        return $newReceive;
    }
}
