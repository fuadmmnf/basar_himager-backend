<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Http\Requests\Booking\CreateBookingRequest;

use Illuminate\Http\Request;

class BookingController extends ApiController
{

    private $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->middleware('auth:api');
        $this->bookingRepository = $bookingRepository;
    }


    public function fetchAllBookingListByClient($client_id){
        $bookinglist = $this->bookingRepository->getBookingListByClient($client_id);
        return response()->json($bookinglist);
    }

    public function fetchAllBookingsByClientId($client_id){
        $bookings = $this->bookingRepository->getAllBookingListByClientId($client_id);
        return response()->json($bookings);
    }

    public function fetchBookingsBySearchedQuery(Request $request)
    {
        $bookings = $this->bookingRepository->getBookingListBySearchedQuery($request->query('selected_year'), $request->query('query'));
        return response()->json($bookings, 200);
    }
     public function fetchBookingDetail($booking_no){
        $booking = $this->bookingRepository->getBookingDetail($booking_no);
        return response()->json($booking);
    }

    public function fetchBookings(Request $request){
        $bookings = $this->bookingRepository->getPaginatedBookings($request->query('selected_year'), $request->query('booking_type'));
        return response()->json($bookings);
    }
     public function fetchAllBookings(Request $request){
            $bookings = $this->bookingRepository->getAllBookingStats($request->query('selected_year'));
            return response()->json($bookings);
        }


    public function createBooking(CreateBookingRequest $request){

        $booking = $this->bookingRepository->saveBooking($request->validated());
        return response()->json($booking, 201);
    }

}
