<?php


namespace App\Repositories;


use App\Exceptions\UserTokenHandler;
use App\Models\Bank;
use App\Models\Bankdeposit;
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
    public function fetchAllSalaries($month)
    {
        // TODO: Implement fetchAllSalaries() method.
        $salaries = Employeesalary::whereMonth('payment_time',Carbon::parse($month))->with('employee')->get();
        return $salaries;
    }

    public function getDeposits($month)
    {
        // TODO: Implement getDeposits() method.
        $deposits = Bankdeposit::whereMonth('created_at',Carbon::parse($month))->with('bank')->get();
        return $deposits;
    }

    public function getBanks()
    {
        // TODO: Implement getBanks() method.
        $banks = Bank::get();
        return $banks;
    }

}


