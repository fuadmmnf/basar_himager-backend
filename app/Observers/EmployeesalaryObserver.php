<?php

namespace App\Observers;

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
        //
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
