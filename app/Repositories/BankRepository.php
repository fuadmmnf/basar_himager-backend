<?php


namespace App\Repositories;



use App\Models\Bank;
use App\Models\Bankdeposit;
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

    public function addBankDeposit(array $request)
    {
        // TODO: Implement addBankDeposit() method.
        $bank = Bank::findOrFail($request['bank_id']);
        $newBankDeposit = new Bankdeposit();
        $newBankDeposit->bank_id = $bank->id;
        $newBankDeposit->si_no = $request['si_no'];
        $newBankDeposit->branch = $request['branch'];
        $newBankDeposit->amount = $request['amount'];
        $newBankDeposit->save();
        return $newBankDeposit;

    }
}


