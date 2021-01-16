<?php


namespace App\Repositories;


use App\Handlers\EmployeeLoanHandler;
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

        $employeeloanHandler = new EmployeeLoanHandler();
        $employeeloan = $employeeloanHandler->createEmployeeLoan($employee, $request['type'], $request['amount'], Carbon::parse($request['payment_time'])->setTimezone('Asia/Dhaka'));

        return $employeeloan;
    }

    public function getEmployeeLoan($employee_id)
    {
        // TODO: Implement getEmployeeLoan() method.
        $loan = Employeeloan::where('employee_id', $employee_id)
            ->orderByDesc('payment_time')
            ->paginate(15);
        return $loan;
    }

}


