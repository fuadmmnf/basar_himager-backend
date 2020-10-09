<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    private $bookingRepository;

    /**
     * EmployeeController constructor.
     */
    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
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
}
