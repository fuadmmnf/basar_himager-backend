<?php


namespace App\Repositories\Interfaces;


interface BookingRepositoryInterface
{
    public function getBookingDetail($booking_no);
    public function getPaginatedRecentBookings();
    public function saveBooking(array $request);
}
