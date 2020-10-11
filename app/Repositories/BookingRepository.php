<?php


namespace App\Repositories;



use App\Handlers\ClientHandler;
use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Carbon\Carbon;

class BookingRepository implements BookingRepositoryInterface
{
    public function getBookingDetail($booking_no){
        $booking = Booking::where('booking_no', $booking_no)->firstOrFail();
        $booking->load('client');
        return $booking;
    }

    public function getPaginatedRecentBookings()
    {
        $bookings = Booking::orderByDesc('booking_time')->with('client')->paginate(25);
        return $bookings;
    }

    public function saveBooking(array $request)
    {
        $clientHandler = new ClientHandler();

        $client = $clientHandler->saveClient($request['nid'], $request['name'],$request['father_name'], $request['address']);
        $newBooking = new Booking();

        $newBooking->client_id = $client->id;
        $newBooking->booking_no = substr(md5(time()),0,8);
        $newBooking->type = $request['type'];
        $newBooking->advance_payment = $request['advance_payment'];
        $newBooking->quantity = $request['quantity'];
        $newBooking->discount = $request['discount'];
        $newBooking->booking_time = Carbon::parse($request['booking_time']);

        $newBooking->save();

        return $newBooking;

    }
}
