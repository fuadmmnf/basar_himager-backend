<?php


namespace App\Repositories\Interfaces;


interface BookingRepositoryInterface
{
    public function getPaginatedReceivesByBookingId($booking_id);
}
