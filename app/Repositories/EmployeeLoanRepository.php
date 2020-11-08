<?php


namespace App\Repositories;


use App\Handlers\UserTokenHandler;
use App\Models\Employee;
use App\Models\Employeeloan;
use App\Models\Employeesalary;
use App\Models\User;
use App\Repositories\Interfaces\EmployeeLoanRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class EmployeeLoanRepository implements EmployeeLoanRepositoryInterface
{
    public function createEmployeeLoan(array $request)
    {
        // TODO: Implement createEmployeeLoan() method.
        $employee = Employee::findOrFail($request['employee_id']);
        $newEmployeeLoan = new Employeeloan();
        $newEmployeeLoan->employee_id = $employee->id;
        $newEmployeeLoan->type = $request['type'];
        $newEmployeeLoan->amount = $request['amount'];
        $newEmployeeLoan->payment_time = Carbon::parse($request['payment_time']);
        $newEmployeeLoan->save();

        $employee->loan += $request['type'] ? -$newEmployeeLoan->amount : $newEmployeeLoan->amount;
        $employee->save();

        return $newEmployeeLoan;
    }

    public function getEmployeeLoan($employee_id)
    {
        // TODO: Implement getEmployeeLoan() method.
        $loan = Employeeloan::where('employee_id', $employee_id)->orderBy('payment_time')->get();
        return $loan;
    }

}


