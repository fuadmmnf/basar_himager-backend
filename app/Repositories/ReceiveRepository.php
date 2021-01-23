<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\Receive;
use App\Models\Receivegroup;
use App\Models\Receiveitem;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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


    private function createReceive(Receivegroup $receivegroup, array $reciveRequest)
    {
        $booking = Booking::findOrFail($reciveRequest['booking_id']);
        $newReceive = new Receive();
        $newReceive->receivegroup_id = $receivegroup->id;
        $newReceive->booking_id = $booking->id;

        $totalQuantity = 0;

        $receiveitems = [];
        foreach ($reciveRequest['receiveitems'] as $receiveitem) {
            if (isset($receiveitems[$receiveitem['potatoe_type']])) {
                $receiveitems[$receiveitem['potatoe_type']] += $receiveitem['quantity'];
            } else {
                $receiveitems[$receiveitem['potatoe_type']] = $receiveitem['quantity'];
            }
            $totalQuantity += $receiveitem['quantity'];
        }

        if ($booking->bags_in + $totalQuantity > $booking->quantity) {
            return null;
        }
        $newReceive->booking_currently_left = $booking->quantity - $booking->bags_in - $totalQuantity;
        $newReceive->transport = $reciveRequest['transport'];

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

    public function saveReceivegroup(array $request)
    {
        DB::beginTransaction();
        try {
            $newReceivegroup = new Receivegroup();
            $newReceivegroup->receiving_time = Carbon::parse($request['receiving_time'])->setTimezone('Asia/Dhaka');
            $newReceivegroup->receiving_no = sprintf('%04d', Receivegroup::whereYear('receiving_time', $newReceivegroup->receiving_time)->count()) . $newReceivegroup->receiving_time->year % 100;
            $newReceivegroup->save();

            foreach ($request['receives'] as $receiveRequest) {
                $this->createReceive($newReceivegroup, $receiveRequest);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $newReceivegroup;
    }

}
