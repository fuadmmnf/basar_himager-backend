<?php


namespace App\Repositories;
use App\Models\Delivery;
use App\Models\Loandisbursement;
use App\Models\Receive;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingRepository implements BookingRepositoryInterface
{

    public function getPaginatedReceivesByBookingId($booking_id)
    {
        // TODO: Implement getPaginatedReceivesByBookingId() method.
        $receives = Receive::where('booking_id', $booking_id)->get();
        return $receives;
    }

    public function getPaginatedDeliveriesByBookingId($booking_id)
    {
        // TODO: Implement getPaginatedDeliveriesByBookingId() method.
        $deliveries = Delivery::where('booking_id', $booking_id)->get();
        return $deliveries;
    }

    public function getPaginatedLoanDisbursementByBookingId($booking_id)
    {
        // TODO: Implement getPaginatedLoanDisbursementByBookingId() method.
        $disbursements = Loandisbursement::where('booking_id', $booking_id)->get();
        return $disbursements;
    }

}
