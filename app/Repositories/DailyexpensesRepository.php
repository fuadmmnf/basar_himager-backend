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
        $newDailyexpenses->type = $request['type'];
        $newDailyexpenses->voucher_no = $request['voucher_no'];
        $newDailyexpenses->date = Carbon::parse($request['date'])->setTimezone('Asia/Dhaka');
        $newDailyexpenses->amount = $request['amount'];
        $newDailyexpenses->remarks = isset($request['remarks'])? $request['remarks'] : '';
        $newDailyexpenses->save();

        return $newDailyexpenses;

    }

    public function getDailyExpenses()
    {
        $dailyexpenses = Dailyexpense::orderByDesc('updated_at')->with('expensecategory')->paginate(20);
        return $dailyexpenses;
        // TODO: Implement getDailyExpenses() method.
    }
}
