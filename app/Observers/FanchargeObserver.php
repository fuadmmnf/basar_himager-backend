<?php

namespace App\Observers;

use App\Handlers\TransactionHandler;
use App\Models\Fancharge;

class FanchargeObserver
{
    /**
     * Handle the fancharge "created" event.
     *
     * @param \App\Models\Fancharge $fancharge
     * @return void
     */
    public function created(Fancharge $fancharge)
    {
        if ($fancharge->total_amount > 0) {
            $transactionHandler = new TransactionHandler();
            $transactionHandler->createTransaction(0, $fancharge->total_amount, $fancharge->date,
                $fancharge, 'Fan Charge',$fancharge->year
            );
        }
    }

    /**
     * Handle the fancharge "updated" event.
     *
     * @param \App\Models\Fancharge $fancharge
     * @return void
     */
    public function updated(Fancharge $fancharge)
    {
        //
    }

    /**
     * Handle the fancharge "deleted" event.
     *
     * @param \App\Models\Fancharge $fancharge
     * @return void
     */
    public function deleted(Fancharge $fancharge)
    {
        //
    }

    /**
     * Handle the fancharge "restored" event.
     *
     * @param \App\Models\Fancharge $fancharge
     * @return void
     */
    public function restored(Fancharge $fancharge)
    {
        //
    }

    /**
     * Handle the fancharge "force deleted" event.
     *
     * @param \App\Models\Fancharge $fancharge
     * @return void
     */
    public function forceDeleted(Fancharge $fancharge)
    {
        //
    }
}
