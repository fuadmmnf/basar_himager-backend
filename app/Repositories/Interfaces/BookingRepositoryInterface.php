<?php


namespace App\Repositories\Interfaces;


interface BookingRepositoryInterface
{
    public function getBookingListBySearchedQuery($year, $query);
    public function getBookingDetail($booking_no);
    public function getPaginatedBookings($year, $booking_type);
    public function getAllBookingStats($year);
    public function getBookingListByClient($client_id);
    public function getAllBookingListByClientId($client_id);
    public function saveBooking(array $request);
}
