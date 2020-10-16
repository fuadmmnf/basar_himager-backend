<?php


namespace App\Repositories;



use App\Models\Bank;
use App\Repositories\Interfaces\BankRepositoryInterface;

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

    public function getBanks()
    {
        // TODO: Implement getBanks() method.
        $banks = Bank::paginate(15);
        return $banks;
    }
}


