<?php

namespace App\Observers;

use App\Handlers\TransactionHandler;
use App\Models\Loancollection;

class LoancollectionObserver
{
    /**
     * Handle the loancollection "created" event.
     *
     * @param  \App\Models\Loancollection  $loancollection
     * @return void
     */
    public function created(Loancollection $loancollection)
    {
        $transactionHandler = new TransactionHandler();
        $transactionHandler->createTransaction(0, $loancollection->payment_amount + $loancollection->surcharge, $loancollection->payment_date,
            $loancollection, 'Booking Loan Collection'
        );
    }

    /**
     * Handle the loancollection "updated" event.
     *
     * @param  \App\Models\Loancollection  $loancollection
     * @return void
     */
    public function updated(Loancollection $loancollection)
    {
        //
    }

    /**
     * Handle the loancollection "deleted" event.
     *
     * @param  \App\Models\Loancollection  $loancollection
     * @return void
     */
    public function deleted(Loancollection $loancollection)
    {
        //
    }

    /**
     * Handle the loancollection "restored" event.
     *
     * @param  \App\Models\Loancollection  $loancollection
     * @return void
     */
    public function restored(Loancollection $loancollection)
    {
        //
    }

    /**
     * Handle the loancollection "force deleted" event.
     *
     * @param  \App\Models\Loancollection  $loancollection
     * @return void
     */
    public function forceDeleted(Loancollection $loancollection)
    {
        //
    }
}
