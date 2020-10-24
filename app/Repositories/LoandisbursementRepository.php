<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Loandisbursement;
use App\Repositories\Interfaces\LoandisbursementRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LoandisbursementRepository implements LoandisbursementRepositoryInterface
{

    public function saveLoan(array $request)
    {
        $booking = Booking::findOrFail($request['booking_id']);

        $newLoandisbursement = new Loandisbursement();
        $newLoandisbursement->booking_id = $booking->id;
        $newLoandisbursement->loandisbursement_no = Str::random(8);
        $newLoandisbursement->amount = $request['amount'];
        $newLoandisbursement->amount_left = $newLoandisbursement->amount;
        $newLoandisbursement->payment_date = Carbon::parse($request['payment_date']);
        $newLoandisbursement->save();

        return $newLoandisbursement;
    }
}
