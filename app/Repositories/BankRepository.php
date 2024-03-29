<?php


namespace App\Repositories;


use App\Models\Bank;
use App\Models\Bankdeposit;
use App\Repositories\Interfaces\BankRepositoryInterface;
use Carbon\Carbon;

class BankRepository implements BankRepositoryInterface
{
    public function createBank(array $request)
    {
//
        $newBank = new Bank();
        $newBank->name = $request['name'];
        $newBank->account_no = $request['account_no'];
        $newBank->total = $request['total'];
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

        if($request['type'] == 1 && $bank->total < $request['amount']){
            return null;
        }


        $newBankDeposit = new Bankdeposit();
        $newBankDeposit->bank_id = $bank->id;
        $newBankDeposit->si_no = $request['si_no'];
        $newBankDeposit->type = $request['type'];
        $newBankDeposit->branch = $request['branch'];
        $newBankDeposit->amount = $request['amount'];
        $newBankDeposit->time = Carbon::parse($request['time'])->setTimezone('Asia/Dhaka');
        $newBankDeposit->save();

        $bank->total += $request['type'] ? -$newBankDeposit->amount : $newBankDeposit->amount;
        $bank->save();

        return $newBankDeposit;

    }

    public function getDeposits($type)
    {
        // TODO: Implement getDeposits() method.
        $deposits = Bankdeposit::where('type', $type)
            ->orderByDesc('time')
            ->with('bank')
            ->paginate(30);
        return $deposits;
    }

}


