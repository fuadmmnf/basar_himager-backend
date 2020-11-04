<?php

namespace App\Observers;

use App\Models\Loandisbursement;

class LoandisbursementObserver
{
    /**
     * Handle the loandisbursement "created" event.
     *
     * @param  \App\Models\Loandisbursement  $loandisbursement
     * @return void
     */
    public function created(Loandisbursement $loandisbursement)
    {
        //
    }

    /**
     * Handle the loandisbursement "updated" event.
     *
     * @param  \App\Models\Loandisbursement  $loandisbursement
     * @return void
     */
    public function updated(Loandisbursement $loandisbursement)
    {
        //
    }

    /**
     * Handle the loandisbursement "deleted" event.
     *
     * @param  \App\Models\Loandisbursement  $loandisbursement
     * @return void
     */
    public function deleted(Loandisbursement $loandisbursement)
    {
        //
    }

    /**
     * Handle the loandisbursement "restored" event.
     *
     * @param  \App\Models\Loandisbursement  $loandisbursement
     * @return void
     */
    public function restored(Loandisbursement $loandisbursement)
    {
        //
    }

    /**
     * Handle the loandisbursement "force deleted" event.
     *
     * @param  \App\Models\Loandisbursement  $loandisbursement
     * @return void
     */
    public function forceDeleted(Loandisbursement $loandisbursement)
    {
        //
    }
}
