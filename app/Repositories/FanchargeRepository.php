<?php


namespace App\Repositories;


use App\Models\Fancharge;
use App\Models\Potatotype;
use App\Models\settings;
use App\Repositories\Interfaces\FanchargeRepositoryInterface;

class FanchargeRepository implements FanchargeRepositoryInterface
{

    public function getFancharges()
    {
        // TODO: Implement getPotatotypes() method.
        $fancharges = Fancharge::all();
        return $fancharges;
    }

    public function storeFancharge(array $request)
    {
        $sttings = settings::where('key', 'fancost_per_bag')->first();

        foreach ($request['fanneditems'] as $fi){
            foreach ($fi['fanneditems'] as $item){

                $newFancharge = new Fancharge();
                $newFancharge->booking_id = $fi['booking_id'];
                $newFancharge->srlot_no = $item['srlot_no'];
                $newFancharge->quantity_bags_fanned = $item['quantity'];
                $newFancharge->total_amount = $item['quantity'] * $sttings->value;
                $newFancharge->save();
            }
        }

        return "Success";

    }
}
