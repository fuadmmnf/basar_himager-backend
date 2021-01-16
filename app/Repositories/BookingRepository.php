<?php


namespace App\Repositories;

use App\Models\Booking;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Handlers\ClientHandler;
use Carbon\Carbon;

class BookingRepository implements BookingRepositoryInterface
{

    public function getPaginatedReceivesByBookingId($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $receives = $booking->receives()->paginate(15);

        return $receives;
    }

    public function getPaginatedDeliveriesByBookingId($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $deliveries = $booking->deliveries()->paginate(15);

        return $deliveries;
    }

    public function getPaginatedLoanDisbursementByBookingId($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $disbursements = $booking->loanDisbursements()->paginate(15);
        return $disbursements;
    }

    public function getPaginatedLoanCollectionByBookingId($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $collections = $booking->loanCollections()->paginate(15);
        return $collections;
    }

    public function getBookingListBySearchedQuery($query)
    {
        $bookings = Booking::select('bookings.*')
            ->where('bookings.booking_no', 'LIKE', '%' . $query . '%')
            ->join('clients', 'clients.id', '=', 'bookings.client_id')
            ->orWhere('clients.phone', 'LIKE', '%' . $query . '%')
            ->take(20)
            ->get();
        return $bookings;
    }

    public function getBookingDetail($booking_no)
    {
        $booking = Booking::where('booking_no', $booking_no)->firstOrFail();
        $booking->load('client', 'receives', 'receives.receiveitems', 'loandisbursements');
        return $booking;
    }

    public function getPaginatedRecentBookings()
    {
        $bookings = Booking::orderByDesc('booking_time')->with('client')->paginate(25);
        return $bookings;
    }

    public function saveBooking(array $request)
    {
        $newBooking = new Booking();

        $newBooking->client_id = $request['client_id'];
        $newBooking->booking_time = Carbon::parse($request['booking_time'])->setTimezone('Asia/Dhaka');
        $newBooking->type = $request['type'];

        $newBooking->booking_no = (($newBooking->type) ? 'A' : 'N')
            . sprintf('%04d', Booking::whereYear('booking_time', $newBooking->booking_time)->count())
            . $newBooking->booking_time->year % 100;
        $newBooking->advance_payment = $request['advance_payment'];
        $newBooking->quantity = $request['quantity'];
        $newBooking->cost_per_bag = $request['cost_per_bag'];
        $newBooking->booking_amount = $request['booking_amount'];
        $newBooking->discount = $request['discount'];

        $newBooking->save();

        return $newBooking;

    }


}
