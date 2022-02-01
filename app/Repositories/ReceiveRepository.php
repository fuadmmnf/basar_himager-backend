<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\Receive;
use App\Models\Receivegroup;
use App\Models\Receiveitem;
use App\Models\settings;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReceiveRepository implements ReceiveRepositoryInterface
{
    public function getReceiveDetails($sr_no)
    {
        $receive = Receive::where('sr_no', $sr_no)->firstOrFail();
        $receive->load('booking', 'booking.client', 'loaddistributions');

        return $receive;
    }



//    public function getReceivegroupDetails($receive_no)
//    {
//        $receive = Receive::where('receiving_no', $receive_no)->firstOrFail();
//        $receive->load('booking', 'booking.client', 'loaddistributions');
//        return $receive;
//    }

    public function getReceiveByGroupId($id)
    {
        // TODO: Implement getReceiveById() method.
        $receive = Receive::where('receivegroup_id', $id)
            ->with('booking')
            ->with('booking.client')
            ->with('receiveitems')
            ->with('receivegroup')
            ->get();

        return $receive;
    }

    public function getReceivesBySearchedQuery($year, $query)
    {
        $receivegroups = Receivegroup::select('receivegroups.*')
            ->where('receiving_year', $year)
            ->join('receives', 'receives.receivegroup_id', '=', 'receivegroups.id')
            ->join('bookings', 'bookings.id', '=', 'receives.booking_id')
            ->where(function ($q) use ($query) {
                $q->where('receivegroups.receiving_no', 'LIKE', $query . '%')
                    ->orWhere('receives.sr_no', 'LIKE', '%' . $query . '%')
                    ->orWhere('bookings.booking_no', 'LIKE', $query . '%');
            })
            ->with('receives.booking')
            ->with('receives.booking.client')
            ->paginate(15);

        return $receivegroups;
    }

    public function getRecentReceives()
    {
        $receives = Receive::orderByDesc('created_at')
            ->with('booking')
            ->with('booking.client')
            ->with('receiveitems')
            ->with('receivegroup')
            ->paginate(20);
        return $receives;
    }

    public function getRecentReceiveGroups($year){
        $recive_groups = Receivegroup::orderByDesc('receiving_time')
            ->where('receiving_year', $year)
            ->with('receives.booking')
            ->with('receives.booking.client')
            ->paginate(20);

        return $recive_groups;
    }

    public function getPaginatedReceivesByBookingId($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $receives =Receive::where('booking_id', $booking->id)
        ->with('receivegroup')
        ->paginate(15);
        return $receives;
    }

    private function createReceive(Receivegroup $receivegroup, array $reciveRequest)
    {
        $booking = Booking::findOrFail($reciveRequest['booking_id']);
        $currentSR = settings::where('key', 'current_sr_no')->first();
        $currentSR->value += 1;

        $newReceive = new Receive();
        $newReceive->receivegroup_id = $receivegroup->id;
        $newReceive->booking_id = $booking->id;

        $totalQuantity = 0;

        $receiveitems = [];
        foreach ($reciveRequest['receiveitems'] as $receiveitem) {
            if (isset($receiveitems[$receiveitem['potato_type']])) {
                $receiveitems[$receiveitem['potato_type']] += $receiveitem['quantity'];
            } else {
                $receiveitems[$receiveitem['potato_type']] = $receiveitem['quantity'];
            }
            $totalQuantity += $receiveitem['quantity'];
        }

        if ($booking->bags_in + $totalQuantity > $booking->quantity) {
            throw new \Exception('receive cannot be greater than booking quantity');
        }

//        $newReceive->sr_no = date('Y') . '_' . $currentSR;
        $newReceive->sr_no = date('Y') . '_' . $currentSR->value;
        $newReceive->lot_no = $currentSR->value . '/' . $totalQuantity;
        $newReceive->booking_currently_left = $booking->quantity - $booking->bags_in - $totalQuantity;
        $newReceive->transport = $reciveRequest['transport'];
        $newReceive->farmer_info = $reciveRequest['farmer_info'];

        $newReceive->save();
        $currentSR->save();

        foreach ($receiveitems as $potato_type => $quantity) {
            $newReceiveItem = new Receiveitem();
            $newReceiveItem->receive_id = $newReceive->id;
            $newReceiveItem->quantity = $quantity;
            $newReceiveItem->quantity_left = $newReceiveItem->quantity;
            $newReceiveItem->potato_type = $potato_type;
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
            $bookingnoArr = array_column($request['receives'], 'booking_no');
            if(count($bookingnoArr) != -1 && count($bookingnoArr) != count(array_unique($bookingnoArr))){

                throw new \Exception('duplicate booking no. exists');
            }


            $newReceivegroup = new Receivegroup();
            $newReceivegroup->receiving_time = Carbon::parse($request['receiving_time'])->setTimezone('Asia/Dhaka');
            $newReceivegroup->receiving_year = Carbon::parse($request['receiving_time'])->setTimezone('Asia/Dhaka')->year;
            $newReceivegroup->receiving_no = sprintf('%04d', Receivegroup::whereYear('receiving_time', $newReceivegroup->receiving_time)->count() + 1) . $newReceivegroup->receiving_time->year % 100;
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
