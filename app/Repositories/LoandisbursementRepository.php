<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Loandisbursement;
use App\Repositories\Interfaces\LoandisbursementRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoandisbursementRepository implements LoandisbursementRepositoryInterface
{
    public function fetchPaginatedLoanDisbursements($year)
    {
        $loanDisbursements = Loandisbursement::orderByDesc('updated_at')
            ->where('payment_year', $year)->paginate(20);
        $loanDisbursements->load('booking', 'booking.client', 'loancollections');
        return $loanDisbursements;
    }

    public function getPaginatedLoanDisbursementByBookingId($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $disbursements = $booking->loanDisbursements()->paginate(15);
        return $disbursements;
    }

    public function fetchPaginatedClientsWithLoan($year){

//        $loanDisbursements = Loandisbursement::select('loandisbursements.*')->orderByDesc('updated_at')
//            ->where('payment_year', $year)->where('amount_left', '>', 0)
//            ->join('bookings', 'bookings.id', '=', 'loandisbursements.booking_id')
//            ->join('clients', 'clients.id', '=', 'bookings.client_id')
//            ->select('clients.*', DB::raw('SUM(amount) as amount' ), DB::raw('SUM(amount_left) as amount_left' )) ->groupBy('clients.id')
//            ->paginate(20);
//        return $loanDisbursements;

        $loanDisbursements = Loandisbursement::select('clients.*')
            ->selectRaw('SUM(loandisbursements.amount) as amount')
            ->selectRaw('SUM(loandisbursements.amount_left) as amount_left')
            ->orderByDesc('loandisbursements.updated_at')
            ->where('loandisbursements.payment_year', $year)
            ->where('loandisbursements.amount_left', '>', 0)
            ->join('bookings', 'bookings.id', '=', 'loandisbursements.booking_id')
            ->join('clients', 'clients.id', '=', 'bookings.client_id')
            ->groupBy('clients.id')
            ->paginate(20);

        return $loanDisbursements;
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
        $newLoandisbursement->payment_year = $request['selected_year'];
        $newLoandisbursement->save();

        return $newLoandisbursement;
    }

    public function fetchLoanByQuery($year, $query)
    {
        $loans = Loandisbursement::select('loandisbursements.*')
            ->where('loandisbursements.payment_year', $year)
            ->join('bookings', 'bookings.id', '=', 'loandisbursements.booking_id')
            ->join('clients', 'clients.id', '=', 'bookings.client_id')
            ->where(function ($q) use ($query) {
                $q->where('bookings.booking_no', 'LIKE', $query . '%')
                    ->orWhere('loandisbursements.loandisbursement_no', 'LIKE', $query . '%')
                    ->orWhere('clients.phone', 'LIKE', $query . '%')
                    ->orWhere('clients.name', 'LIKE', '%' . $query . '%');
            })
            ->with('booking','booking.client','loancollections')
            ->paginate(15);
        return $loans;
        // TODO: Implement fetchLoanByQuery() method.
    }
}
