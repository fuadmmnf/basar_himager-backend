<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Loandisbursement;
use App\Repositories\Interfaces\LoandisbursementRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LoandisbursementRepository implements LoandisbursementRepositoryInterface
{
    public function fetchPaginatedLoanDisbursements()
    {
        $loanDisbursements = Loandisbursement::orderByDesc('updated_at')->paginate(20);
        $loanDisbursements->load('booking', 'booking.client', 'loancollections');
        return $loanDisbursements;
    }

    public function getPaginatedLoanDisbursementByBookingId($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $disbursements = $booking->loanDisbursements()->paginate(15);
        return $disbursements;
    }

    public function saveLoan(array $request)
    {
        $booking = Booking::findOrFail($request['booking_id']);

        $newLoandisbursement = new Loandisbursement();
        $newLoandisbursement->booking_id = $booking->id;
        $newLoandisbursement->loandisbursement_no = Str::random(8);
        $newLoandisbursement->amount = $request['amount'];
        $newLoandisbursement->amount_left = $newLoandisbursement->amount;
        $newLoandisbursement->payment_date = Carbon::parse($request['payment_date'])->setTimezone('Asia/Dhaka');
        $newLoandisbursement->save();

        return $newLoandisbursement;
    }
}
