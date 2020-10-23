<?php


namespace App\Repositories;


use App\Exceptions\UserTokenHandler;
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
        $salaries = Employeesalary::whereMonth('payment_time',Carbon::now())->with('employee')->paginate(15);
        return $salaries;
    }
    public function storeEmployeeSalary(array $request)
    {
        // TODO: Implement storeEmployeeSalary() method.
        $employee = Employee::findOrFail($request['employee_id']);
        $newEmployeeSalary = new Employeesalary();
        $newEmployeeSalary->employee_id = $employee->id;
        $newEmployeeSalary->basic_salary = $request['basic_salary'];
        $newEmployeeSalary->special_salary = $request['special_salary'];
        $newEmployeeSalary->eid_bonus = $request['eid_bonus'];
        $newEmployeeSalary->payment_time = Carbon::parse($request['payment_time']);
        $newEmployeeSalary->save();
        return $newEmployeeSalary;

    }

}


