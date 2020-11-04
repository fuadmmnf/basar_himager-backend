<?php

namespace App\Observers;

use App\Handlers\TransactionHandler;
use App\Models\Employeesalary;

class EmployeesalaryObserver
{
    /**
     * Handle the employeesalary "created" event.
     *
     * @param  \App\Models\Employeesalary  $employeesalary
     * @return void
     */
    public function created(Employeesalary $employeesalary)
    {
        $transactionHandler = new TransactionHandler();
        $transactionHandler->createTransaction($employeesalary->type == 0? 1: 0, $employeesalary->amount + $employeesalary->bonus, $employeesalary->payment_time,
            $employeesalary, 'Employee Monthly Salary'
        );
    }

    /**
     * Handle the employeesalary "updated" event.
     *
     * @param  \App\Models\Employeesalary  $employeesalary
     * @return void
     */
    public function updated(Employeesalary $employeesalary)
    {
        //
    }

    /**
     * Handle the employeesalary "deleted" event.
     *
     * @param  \App\Models\Employeesalary  $employeesalary
     * @return void
     */
    public function deleted(Employeesalary $employeesalary)
    {
        //
    }

    /**
     * Handle the employeesalary "restored" event.
     *
     * @param  \App\Models\Employeesalary  $employeesalary
     * @return void
     */
    public function restored(Employeesalary $employeesalary)
    {
        //
    }

    /**
     * Handle the employeesalary "force deleted" event.
     *
     * @param  \App\Models\Employeesalary  $employeesalary
     * @return void
     */
    public function forceDeleted(Employeesalary $employeesalary)
    {
        //
    }
}
