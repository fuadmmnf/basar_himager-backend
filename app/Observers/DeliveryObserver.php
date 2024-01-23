<?php

namespace App\Observers;

use App\Handlers\TransactionHandler;
use App\Models\Delivery;
use App\Models\Transaction;
use Carbon\Carbon;

class DeliveryObserver
{
    /**
     * Handle the delivery "created" event.
     *
     * @param \App\Models\Delivery $delivery
     * @return void
     */
    public function created(Delivery $delivery)
    {
        if($delivery->total_charge > 0){
            $fancost = $delivery->quantity_bags_fanned * $delivery->fancost_per_bag;
            $quantity = ($delivery->total_charge - $fancost)/($delivery->do_charge + $delivery->cost_per_bag);
            $transactionHandler = new TransactionHandler();

            $transactionHandler->createTransaction(0, $quantity * $delivery->cost_per_bag, Carbon::parse($delivery->deliverygroup->delivery_time)->setTimezone('Asia/Dhaka'),
                $delivery, 'Delivery Charge',$delivery->year
            );
            $transactionHandler->createTransaction(0, $quantity * $delivery->do_charge, Carbon::parse($delivery->deliverygroup->delivery_time)->setTimezone('Asia/Dhaka'),
                $delivery, 'Delivery DO Charge',$delivery->year
            );
        }

    }

    /**
     * Handle the delivery "updated" event.
     *
     * @param \App\Models\Delivery $delivery
     * @return void
     */
    public function updated(Delivery $delivery)
    {
        $transactionHandler = new TransactionHandler();
        $transactionHandler->createTransaction(0, $delivery->quantity_bags_fanned * $delivery->fancost_per_bag, Carbon::parse($delivery->deliverygroup->delivery_time)->setTimezone('Asia/Dhaka'),
            $delivery, 'Delivery Fan Charge',$delivery->year
        );
    }

    /**
     * Handle the delivery "deleted" event.
     *
     * @param \App\Models\Delivery $delivery
     * @return void
     */
    public function deleted(Delivery $delivery)
    {
        //
    }

    /**
     * Handle the delivery "restored" event.
     *
     * @param \App\Models\Delivery $delivery
     * @return void
     */
    public function restored(Delivery $delivery)
    {
        //
    }

    /**
     * Handle the delivery "force deleted" event.
     *
     * @param \App\Models\Delivery $delivery
     * @return void
     */
    public function forceDeleted(Delivery $delivery)
    {
        //
    }
}
