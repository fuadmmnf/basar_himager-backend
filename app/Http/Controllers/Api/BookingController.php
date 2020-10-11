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
        $this->bookingRepository = $bookingRepository;
    }

    public function createBooking(CreateBookingRequest $request){

        $booking = $this->bookingRepository->saveBooking($request->validated());
        return response()->json($booking, 201);
    }
}
