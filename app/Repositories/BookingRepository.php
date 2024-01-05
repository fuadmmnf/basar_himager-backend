<?php


namespace App\Repositories;

use App\Models\Booking;

use App\Models\Client;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Handlers\ClientHandler;
use Carbon\Carbon;

class BookingRepository implements BookingRepositoryInterface
{


    public function getBookingListBySearchedQuery($year, $query)
    {
        $bookings = Booking::select('bookings.*')
            ->where('bookings.booking_year', $year)
            ->join('clients', 'clients.id', '=', 'bookings.client_id')
            ->where(function ($q) use ($query) {
                $q->where('bookings.booking_no', 'LIKE', $query . '%')
                    ->orWhere('clients.phone', 'LIKE', $query . '%')
                    ->orWhere('clients.name', 'LIKE', '%' . $query . '%');
            })
            ->with('client')
            ->paginate(15);
        return $bookings;
    }

    public function getBookingDetail($booking_no)
    {
        $booking = Booking::where('booking_no', $booking_no)->firstOrFail();
        $booking->load('client', 'receives', 'receives.receiveitems', 'loandisbursements', 'deliveries', 'receives.receivegroup');
        return $booking;
    }

    public function getPaginatedBookings($year, $booking_type)
    {
        $bookings = Booking::where('booking_year', $year);
        if($booking_type != '2') {
            $bookings = $bookings->where('type', $booking_type);
        }
        $bookings = $bookings->with('client')->paginate(25);
        return $bookings;
    }

      public function getAllBookingStats($year)
        {
            $bookings = Booking::where('booking_year', $year)->get();

            $total_receives = $bookings->sum('bags_in');
            $total_deliveries = $bookings->sum('bags_out');
            $normal_receives = 0;
            $advance_receives = 0;
            $normal_deliveries = 0;
            $advance_deliveries = 0;

            foreach ($bookings as $booking) {
                if($booking->type) {
                    $advance_receives += $booking->bags_in;
                    $advance_deliveries += $booking->bags_out;
                }
                else {
                    $normal_receives += $booking->bags_in;
                    $normal_deliveries += $booking->bags_out;
                }
            }

            $bookings->total_receives = $total_receives;
            $bookings->normal_receives = $normal_receives;
            $bookings->advance_receives = $advance_receives;

            $bookings->total_deliveries = $total_deliveries;
            $bookings->normal_deliveries = $normal_deliveries;
            $bookings->advance_deliveries = $advance_deliveries;

            return [
                'total_receives' => $total_receives,
                'normal_receives' => $normal_receives,
                'advance_receives' => $advance_receives,
                'total_deliveries' => $total_deliveries,
                'normal_deliveries' => $normal_deliveries,
                'advance_deliveries' => $advance_deliveries,
                ];
        }


    public function getBookingListByClient($client_id)
    {
        $bookinglist = Booking::where('client_id', $client_id)
            ->orderByDesc('booking_time')
            ->pluck('booking_no');
        return $bookinglist;
    }

    public function getAllBookingListByClientId($client_id)
    {
        $bookings = Booking::where('client_id', $client_id)
            ->orderByDesc('booking_time')
            ->paginate(15);
        return $bookings;
    }

    private function getBookingNumberForSession($booking)
    {
        $bookingSessionCount = Booking::where('type', $booking->type)
            ->where('booking_year',$booking->booking_year)->count();
        return (($booking->type) ? 'A' : 'N')
            . sprintf('%04d' , $bookingSessionCount + ($booking->type ? 1 : 2101))
            . '_' . ($booking->booking_year ) % 100;
    }

    public function saveBooking(array $request)
    {
        $newBooking = new Booking();
        $newBooking->client_id = $request['client_id'];
        $newBooking->booking_time = Carbon::parse($request['booking_time'])->setTimezone('Asia/Dhaka');
//        $newBooking->booking_year = $newBooking->booking_time->month > 3 ? ($newBooking->booking_time->year+1) : $newBooking->booking_time->year;

        $newBooking->booking_year = $request['selected_year'];
        $newBooking->type = $request['type'];
        $newBooking->booking_no = $this->getBookingNumberForSession($newBooking);
        $newBooking->advance_payment = $request['advance_payment'];
        $newBooking->quantity = $request['quantity'];
        $newBooking->cost_per_bag = $request['cost_per_bag'];
        $newBooking->initial_booking_amount = $request['booking_amount'];
        $newBooking->booking_amount = $request['booking_amount'];
        $newBooking->discount = $request['discount'];

        $newBooking->save();

        return $newBooking;

    }


}
