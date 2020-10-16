<?php


namespace App\Repositories;


use App\Exceptions\UserTokenHandler;
use App\Models\Bank;
use App\Models\Employee;
use App\Models\Employeesalary;
use App\Models\User;
use App\Repositories\Interfaces\BankRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class BankRepository implements BankRepositoryInterface
{
    public function createBank(array $request)
    {
//
        $newBank = new Bank();
        $newBank->name = $request['name'];
        $newBank->account_no = $request['account_no'];
        $newBank->save();
        return $newBank;
    }
}


