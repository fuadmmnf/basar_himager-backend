<?php


namespace App\Repositories;


use App\Models\Fancharge;
use App\Models\Potatotype;
use App\Models\settings;
use App\Repositories\Interfaces\FanchargeRepositoryInterface;
use Carbon\Carbon;

class FanchargeRepository implements FanchargeRepositoryInterface
{

    public function getFancharges()
    {
        // TODO: Implement getPotatotypes() method.
        $fancharges = Fancharge::orderBy('created_at')
            ->with('booking')
            ->paginate(20);
        return $fancharges;
    }

    public function storeFancharge(array $request)
    {
        $sttings = settings::where('key', 'fancost_per_bag')->first();

        foreach ($request['fanneditems'] as $fi){
            foreach ($fi['fanneditems'] as $item){

                $newFancharge = new Fancharge();
                $newFancharge->booking_id = $fi['booking_id'];
                $newFancharge->date =Carbon::parse($request['fancharge_time'])->setTimezone('Asia/Dhaka');
                $newFancharge->srlot_no = $item['srlot_no'];
                $newFancharge->quantity_bags_fanned = $item['quantity'];
                $newFancharge->total_amount = $item['quantity'] * $sttings->value;
                $newFancharge->save();
            }
        }

        return "Success";

    }

    public function getFanchargesBySearchQuery($query)
    {
        // TODO: Implement getFanchargesBySearchQuery() method.
        $fancharges = Fancharge::select('fancharges.*')
            ->join('bookings', 'bookings.id', '=', 'fancharges.booking_id')
            ->where(function ($q) use ($query) {
                $q->where('fancharges.srlot_no', 'LIKE', '%' . $query . '%')
                    ->orWhere('bookings.booking_no', 'LIKE', '%' . $query . '%');
            })
            ->paginate(15);

        $fancharges->load('booking');
        return $fancharges;
    }
}
