<?php


namespace App\Repositories;


use App\Exceptions\UserTokenHandler;
use App\Models\Bank;
use App\Models\Dailyexpense;
use App\Models\Bankdeposit;
use App\Models\Employee;
use App\Models\Employeesalary;
use App\Models\Expensecategory;
use App\Models\User;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\EmployeeSalaryRepositoryInterface;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Collection;
use Spatie\Permission\Models\Role;
use function Sodium\add;

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
        $banks = Bank::orderBy('name', 'asc')->get();
        return $banks;
    }

    public function fetchDailyexpenses($month){
        $expensecategories= Expensecategory::where('category',null)->orderBy('type')->get();
        $expenses = Dailyexpense::whereMonth('date',Carbon::parse($month))->with('expensecategory')->get();

        foreach ($expensecategories as $expensecategory){
            $cost = 0;
            foreach ($expenses as $e){
                if($expensecategory->type == $e->expensecategory->type){
                    $cost = $e->amount + $cost;
                }
            }
            $expensecategory->amount = $cost;

        }
        return $expensecategories;
    }

}


