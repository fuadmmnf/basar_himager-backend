<?php

namespace App\Observers;

use App\Models\Machinepartentry;

class MachinepartentryObserver
{
    /**
     * Handle the machinepartentry "created" event.
     *
     * @param  \App\Models\Machinepartentry  $machinepartentry
     * @return void
     */
    public function created(Machinepartentry $machinepartentry)
    {
        //
    }

    /**
     * Handle the machinepartentry "updated" event.
     *
     * @param  \App\Models\Machinepartentry  $machinepartentry
     * @return void
     */
    public function updated(Machinepartentry $machinepartentry)
    {
        //
    }

    /**
     * Handle the machinepartentry "deleted" event.
     *
     * @param  \App\Models\Machinepartentry  $machinepartentry
     * @return void
     */
    public function deleted(Machinepartentry $machinepartentry)
    {
        //
    }

    /**
     * Handle the machinepartentry "restored" event.
     *
     * @param  \App\Models\Machinepartentry  $machinepartentry
     * @return void
     */
    public function restored(Machinepartentry $machinepartentry)
    {
        //
    }

    /**
     * Handle the machinepartentry "force deleted" event.
     *
     * @param  \App\Models\Machinepartentry  $machinepartentry
     * @return void
     */
    public function forceDeleted(Machinepartentry $machinepartentry)
    {
        //
    }
}
