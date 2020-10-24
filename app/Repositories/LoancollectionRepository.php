<?php

namespace App\Repositories;

use App\Models\Loancollection;
use App\Models\Loandisbursement;
use App\Repositories\Interfaces\LoancollectionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LoancollectionRepository implements LoancollectionRepositoryInterface
{

    public function saveLoancollection(array $request)
    {
        $loandisbursement = Loandisbursement::findOrFail($request['loandisbursement_id']);
        // TODO: Implement saveLoan() method.
        $newLoancollection = new Loancollection();
        $newLoancollection->loandisbursement_id = $loandisbursement->id;
        $newLoancollection->loancollection_no = Str::random(8);
        $newLoancollection->surcharge = $request['surcharge'];
        $newLoancollection->payment_amount = $request['payment_amount'];
        $newLoancollection->payment_date = Carbon::parse($request('payment_date'));
        $newLoancollection->save();

        $loandisbursement->amount_left = $loandisbursement->amount_left - $newLoancollection->payment_amount;
        $loandisbursement->save();

        return $newLoancollection;
    }
}