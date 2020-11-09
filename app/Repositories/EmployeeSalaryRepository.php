<?php


namespace App\Repositories;


use App\Handlers\EmployeeLoanHandler;
use App\Models\Employee;
use App\Models\Employeesalary;
use App\Models\User;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\EmployeeSalaryRepositoryInterface;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class EmployeeSalaryRepository implements EmployeeSalaryRepositoryInterface
{
    public function fetchAllSalaries()
    {
        // TODO: Implement fetchAllSalaries() method.
        $salaries = Employeesalary::whereMonth('payment_time', Carbon::now())->with('employee')->paginate(15);
        return $salaries;
    }

    public function storeEmployeeSalary(array $request)
    {
        $employee = Employee::findOrFail($request['employee_id']);

        if ($request['amount'] + $request['bonus'] < $request['loan_payment']) {
            return null;
        }

        $employeeloanHandler = new EmployeeLoanHandler();
        $employeeLoan = $employeeloanHandler->createEmployeeLoan($employee, 1, $request['loan_payment'], Carbon::parse($request['payment_time']));
        if (!$employeeLoan) {
            return null;
        }

        $newEmployeeSalary = new Employeesalary();
        $newEmployeeSalary->employee_id = $employee->id;
        $newEmployeeSalary->amount = $request['amount'];
        $newEmployeeSalary->loan_payment = $request['loan_payment'];
        $newEmployeeSalary->bonus = $request['bonus'];
        $newEmployeeSalary->remark = $request['remark'];
        $newEmployeeSalary->salary_month = Carbon::parse($request['salary_month']);
        $newEmployeeSalary->payment_time = Carbon::parse($request['payment_time']);
        $newEmployeeSalary->save();


        return $newEmployeeSalary;
    }

    public function getAdvanceSalary($employee_id)
    {
        // TODO: Implement getAdvanceSalary() method.
        $advance = Employeesalary::where('employee_id', $employee_id)->sum('amount');
        return $advance;
    }


    public function fetchEmployeeSalaryByid($employee_id)
    {
        // TODO: Implement fetchEmployeeSalaryByid() method.
        $salary= Employeesalary::where('employee_id', $employee_id)->orderBy('payment_time')->get();
        return $salary;
    }
}


