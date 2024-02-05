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
        $salaries = Employeesalary::whereMonth('payment_time', Carbon::now()->setTimezone('Asia/Dhaka'))->with('employee')->paginate(15);
        return $salaries;
    }

    public function storeEmployeeSalary(array $request)
    {
        $employee = Employee::findOrFail($request['employee_id']);
        $salary = (int)(($employee->basic_salary + $employee->special_salary) * $request['working_day']) / 30;
        if ($salary + $request['bonus'] < $request['loan_payment']) {
            return null;
        }

        if($request['loan_payment'] > 0){
            $employeeloanHandler = new EmployeeLoanHandler();
            $employeeLoan = $employeeloanHandler->createEmployeeLoan($employee, 2, $request['loan_payment'], Carbon::parse($request['payment_time'])->setTimezone('Asia/Dhaka'),$request['selected_year']);
            if (!$employeeLoan) {
                return null;
            }

        }

        $newEmployeeSalary = new Employeesalary();
        $newEmployeeSalary->employee_id = $employee->id;
        $newEmployeeSalary->amount = $salary;
        $newEmployeeSalary->loan_payment = $request['loan_payment'];
        $newEmployeeSalary->bonus = $request['bonus'];
        $newEmployeeSalary->remark = $request['remark'];
        $newEmployeeSalary->fine = $request['fine'];
        $newEmployeeSalary->fine_remark = $request['fine_remark'];
        $newEmployeeSalary->working_days = $request['working_day'];
        $newEmployeeSalary->current_designation =  $employee->designation;
        $newEmployeeSalary->basic_salary =  $employee->basic_salary;
        $newEmployeeSalary->special_salary =  $employee->special_salary;
        $newEmployeeSalary->year= $request['selected_year'];
        $newEmployeeSalary->salary_month = Carbon::parse($request['salary_month'])->setTimezone('Asia/Dhaka');
        $newEmployeeSalary->payment_time = Carbon::parse($request['payment_time'])->setTimezone('Asia/Dhaka');
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
        $salaries = Employeesalary::where('employee_id', $employee_id)->orderByDesc('salary_month')->paginate(15);
        return $salaries;
    }
}


