<?php

namespace App\Repositories;

use App\Models\Loancollection;
use App\Repositories\Interfaces\LoancollectionRepositoryInterface;
use Carbon\Carbon;

class LoancollectionRepository implements LoancollectionRepositoryInterface
{

    public function saveLoancollection(array $request)
    {
        // TODO: Implement saveLoan() method.
        $newLoancollection = new Loancollection();
        $newLoancollection->loandisbursement_id = $request['loandisbursement_id'];
        $newLoancollection->surcharge = $request['surcharge'];
        $newLoancollection->payment_amount = $request['payment_amount'];
        $newLoancollection->payment_date = Carbon::parse($request('payment_date'));

        $newLoancollection->save();

        return $newLoancollection;
    }
}
