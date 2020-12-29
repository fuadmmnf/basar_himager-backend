<?php


namespace App\Repositories\Interfaces;


interface LoaddistributionRepositoryInterface
{
    public function saveLoaddistrbution(array $request);
    public function getLoadDistrbutionByBooking_id($booking_id);
}
