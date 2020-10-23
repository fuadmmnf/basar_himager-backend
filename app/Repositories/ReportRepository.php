<?php


namespace App\Repositories;


use App\Exceptions\UserTokenHandler;
use App\Models\Employee;
use App\Models\Employeesalary;
use App\Models\User;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\EmployeeSalaryRepositoryInterface;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class ReportRepository implements ReportRepositoryInterface
{
    public function fetchAllSalaries()
    {
        // TODO: Implement fetchAllSalaries() method.
        $salaries = Employeesalary::whereMonth('payment_time',Carbon::now())->with('employee')->paginate(15);
        return $salaries;
    }

}


