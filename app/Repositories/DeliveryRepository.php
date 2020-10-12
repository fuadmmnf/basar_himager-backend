<?php


namespace App\Repositories;


use App\Handlers\UserTokenHandler;
use App\Models\Delivery;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class DeliveryRepository implements DeliveryRepositoryInterface
{
    public function saveDelivery(array $request)
    {
        // TODO: Implement saveDelivery() method.
        $newDelivery = new Delivery();
        $newDelivery->booking_id = $request['booking_id'];
        $newDelivery->delivery_time = Carbon::parse($request['delivery_time']);
        $newDelivery->potatoe_type = $request['potatoe_type'];
        $newDelivery->quantity_bags = $request['quantity_bags'];
        $newDelivery->cost_per_bag = $request['cost_per_bag'];
        $newDelivery->quantity_bags_fanned = $request['quantity_bags_fanned'];
        $newDelivery->fancost_per_bag = $request['fancost_per_bag'];
        $newDelivery->due_charge = $request['due_charge'];
        $newDelivery->total_charge = $request['total_charge'];
        $newDelivery->save();

        return $newDelivery;
    }
}
