<?php


namespace App\Repositories\Interfaces;


interface LoancollectionRepositoryInterface
{
    public function getPaginatedLoanCollectionByBookingId($booking_id);
    public function saveLoancollection(array $request);
}
