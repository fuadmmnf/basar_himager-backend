<?php

namespace App\Repositories;

use App\Models\Loandisbursement;
use App\Repositories\Interfaces\LoandisbursementRepositoryInterface;
use Carbon\Carbon;

class LoandisbursementRepository implements LoandisbursementRepositoryInterface
{

    public function saveLoan(array $request)
    {
        // TODO: Implement saveLoan() method.
        $newLoandisbursement = new Loandisbursement();

        $newLoandisbursement->booking_id = $request['booking_id'];
        $newLoandisbursement->amount = $request['amount'];
        $newLoandisbursement->amount_left = $request['amount_left'];
        $newLoandisbursement->payment_date = Carbon::parse($request['payment_date']);


        $newLoandisbursement->save();

        return $newLoandisbursement;
    }
}
