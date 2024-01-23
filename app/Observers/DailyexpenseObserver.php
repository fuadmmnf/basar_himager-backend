<?php

namespace App\Observers;

use App\Handlers\TransactionHandler;
use App\Models\Dailyexpense;

class DailyexpenseObserver
{
    /**
     * Handle the dailyexpense "created" event.
     *
     * @param  \App\Models\Dailyexpense  $dailyexpense
     * @return void
     */
    public function created(Dailyexpense $dailyexpense)
    {
        $transactionHandler = new TransactionHandler();
        $transactionHandler->createTransaction(1, $dailyexpense->amount, $dailyexpense->date,
            $dailyexpense, 'Daily Expense',$dailyexpense->year
        );
    }

    /**
     * Handle the dailyexpense "updated" event.
     *
     * @param  \App\Models\Dailyexpense  $dailyexpense
     * @return void
     */
    public function updated(Dailyexpense $dailyexpense)
    {
        //
    }

    /**
     * Handle the dailyexpense "deleted" event.
     *
     * @param  \App\Models\Dailyexpense  $dailyexpense
     * @return void
     */
    public function deleted(Dailyexpense $dailyexpense)
    {
        //
    }

    /**
     * Handle the dailyexpense "restored" event.
     *
     * @param  \App\Models\Dailyexpense  $dailyexpense
     * @return void
     */
    public function restored(Dailyexpense $dailyexpense)
    {
        //
    }

    /**
     * Handle the dailyexpense "force deleted" event.
     *
     * @param  \App\Models\Dailyexpense  $dailyexpense
     * @return void
     */
    public function forceDeleted(Dailyexpense $dailyexpense)
    {
        //
    }
}
