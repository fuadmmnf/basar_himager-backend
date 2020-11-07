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
    public function fetchPaginatedReceivesByBookingID($booking_id)
    {
        $receives = $this->bookingRepository->getPaginatedReceivesByBookingId($booking_id);

        return response()->json($receives, 201);
    }

    public function fetchPaginatedDeliveriesByBookingID($booking_id)
    {
        $deliveries = $this->bookingRepository->getPaginatedDeliveriesByBookingId($booking_id);

        return response()->json($deliveries, 201);
    }

    public function fetchPaginatedLoanDisbursementByBookingID($booking_id)
    {
        $disbursements = $this->bookingRepository->getPaginatedLoanDisbursementByBookingId($booking_id);

        return response()->json($disbursements, 201);
    }

    public function fetchPaginatedLoanCollectionByBookingID($booking_id)
    {
        $collections = $this->bookingRepository->getPaginatedLoanCollectionByBookingId($booking_id);

        return response()->json($collections, 201);
    }

    public function bookingListBySearchedQuery($query)
    {
        $bookings = $this->bookingRepository->getBookingListBySearchedQuery($query);

        return response()->json($bookings, 201);
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
