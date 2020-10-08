<?php


namespace App\Repositories;
use App\Models\Booking;
use App\Models\Delivery;
use App\Models\Loancollection;
use App\Models\Loandisbursement;
use App\Models\Receive;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingRepository implements BookingRepositoryInterface
{

    public function getPaginatedReceivesByBookingId($booking_id)
    {
        // TODO: Implement getPaginatedReceivesByBookingId() method.
        $booking = Booking::findOrFail($booking_id);
        $receives = $booking->receives()->paginate(15);

        return $receives;
    }

    public function getPaginatedDeliveriesByBookingId($booking_id)
    {
        // TODO: Implement getPaginatedDeliveriesByBookingId() method.
        $booking = Booking::findOrFail($booking_id);
        $deliveries = $booking->deliveries()->paginate(15);

        return $deliveries;
    }

    public function getPaginatedLoanDisbursementByBookingId($booking_id)
    {
        // TODO: Implement getPaginatedLoanDisbursementByBookingId() method.
        $booking = Booking::findOrFail($booking_id);
        $disbursements = $booking->loanDisbursements()->paginate(15);
        return $disbursements;
    }

    public function getPaginatedLoanCollectionByBookingId($booking_id)
    {
        // TODO: Implement getPaginatedLoanDisbursementByBookingId() method.
        $booking = Booking::findOrFail($booking_id);
        $collections = $booking->loanCollections()->paginate(15);
        return $collections;
    }

}
