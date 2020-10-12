<?php

namespace App\Repositories;



use App\Handlers\ClientHandler;
use App\Models\Dailyexpense;
use App\Repositories\Interfaces\DailyexpensesRepositoryInterface;
use Carbon\Carbon;

class DailyexpensesRepository implements DailyexpensesRepositoryInterface
{

    public function saveDailyexpenses(array $request)
    {
        $newDailyexpenses = new Dailyexpense();
        $newDailyexpenses->expensecategory_id = $request['expensecategory_id'];
        $newDailyexpenses->voucher_no = $request['voucher_no'];
        $newDailyexpenses->date = Carbon::parse($request['date']);
        $newDailyexpenses->amount = $request['amount'];

        $newDailyexpenses->save();

        return $newDailyexpenses;

    }
}
