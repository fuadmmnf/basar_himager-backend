<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CreateBookingRequest;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    private $bookingRepository;

    /**
     * BookingController constructor.
     */
    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->middleware('auth:api');
        $this->bookingRepository = $bookingRepository;
    }

    public function fetchBookingDetail($booking_no){
        $booking = $this->bookingRepository->getBookingDetail($booking_no);
        return response()->json($booking);
    }

    public function fetchBookings(){
        $bookings = $this->bookingRepository->getPaginatedRecentBookings();
        return response()->json($bookings);
    }

    public function createBooking(CreateBookingRequest $request){

        $booking = $this->bookingRepository->saveBooking($request->validated());
        return response()->json($booking, 201);
    }
}
