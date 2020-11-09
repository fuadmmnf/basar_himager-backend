<?php


namespace App\Handlers;


use App\Models\Employee;
use App\Models\Employeeloan;
use Carbon\Carbon;

class EmployeeLoanHandler
{
    public function createEmployeeLoan(Employee $employee, $type, $amount, Carbon $time)
    {
        if($type == 1 && $employee->loan < $amount){
            return null;
        }
        $newEmployeeLoan = new Employeeloan();
        $newEmployeeLoan->employee_id = $employee->id;
        $newEmployeeLoan->type = $type;
        $newEmployeeLoan->amount = $amount;
        $newEmployeeLoan->payment_time = $time;
        $newEmployeeLoan->save();

        $employee->loan += $type ? -$newEmployeeLoan->amount : $newEmployeeLoan->amount;
        $employee->save();

        return $newEmployeeLoan;
    }
}
