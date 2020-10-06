<?php


namespace App\Repositories\Interfaces;


interface BookingRepositoryInterface
{
    public function getPaginatedReceivesByBookingId($booking_id);
    public function getPaginatedDeliveriesByBookingId($booking_id);
}
