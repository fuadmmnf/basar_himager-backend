<?php


namespace App\Repositories\Interfaces;


interface LoaddistributionRepositoryInterface
{
    public function saveLoaddistrbution(array $request);
    public function savePalot(array $request);
    public function getLoadPositionsByBooking($booking_id);
}
