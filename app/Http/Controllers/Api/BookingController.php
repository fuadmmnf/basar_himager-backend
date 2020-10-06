<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\CreateEmployeeRequest;
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
        $receives = $this->bookingRepository->getPaginatedReceivesByBookingId($booking_id)->paginate(15);

        return response()->json($receives, 201);
    }

    public function fetchPaginatedDeliveriesByBookingID($booking_id)
    {
        $deliveries = $this->bookingRepository->getPaginatedDeliveriesByBookingId($booking_id)->paginate(15);

        return response()->json($deliveries, 201);
    }
}
