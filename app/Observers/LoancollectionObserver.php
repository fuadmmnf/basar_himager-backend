<?php

namespace App\Observers;

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
        //
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
