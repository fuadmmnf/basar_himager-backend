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

        if($loandisbursement->amount_left < $request['payment_amount']){
            return null;
        }

        $newLoancollection = new Loancollection();
        $newLoancollection->loandisbursement_id = $loandisbursement->id;
        $newLoancollection->loancollection_no = Str::random(8);
        $newLoancollection->surcharge = $request['surcharge'];
        $newLoancollection->payment_amount = $request['payment_amount'];
        $newLoancollection->pending_loan_amount = $request['pending_loan_amount'];
        $newLoancollection->payment_date = Carbon::parse($request['payment_date'])->setTimezone('Asia/Dhaka');
        $newLoancollection->save();

        $loandisbursement->amount_left = $loandisbursement->amount_left - $newLoancollection->payment_amount;
        $loandisbursement->save();

        return $newLoancollection;
    }
}
