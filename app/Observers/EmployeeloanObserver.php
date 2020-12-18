<?php

namespace App\Observers;

use App\Handlers\TransactionHandler;
use App\Models\Employeeloan;

class EmployeeloanObserver
{
    /**
     * Handle the employeeloan "created" event.
     *
     * @param  \App\Models\Employeeloan  $employeeloan
     * @return void
     */
    public function created(Employeeloan $employeeloan)
    {
        $transactionHandler = new TransactionHandler();
        $transactionHandler->createTransaction($employeeloan->type == 0? 1: 0, $employeeloan->amount, $employeeloan->payment_time,
            $employeeloan, $employeeloan->type == 0? 'Employee Loan Disbursement': 'Employee Loan Collection'
        );
    }

    /**
     * Handle the employeeloan "updated" event.
     *
     * @param  \App\Models\Employeeloan  $employeeloan
     * @return void
     */
    public function updated(Employeeloan $employeeloan)
    {
        //
    }

    /**
     * Handle the employeeloan "deleted" event.
     *
     * @param  \App\Models\Employeeloan  $employeeloan
     * @return void
     */
    public function deleted(Employeeloan $employeeloan)
    {
        //
    }

    /**
     * Handle the employeeloan "restored" event.
     *
     * @param  \App\Models\Employeeloan  $employeeloan
     * @return void
     */
    public function restored(Employeeloan $employeeloan)
    {
        //
    }

    /**
     * Handle the employeeloan "force deleted" event.
     *
     * @param  \App\Models\Employeeloan  $employeeloan
     * @return void
     */
    public function forceDeleted(Employeeloan $employeeloan)
    {
        //
    }
}
