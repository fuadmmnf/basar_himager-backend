<?php


namespace App\Repositories\Interfaces;


interface LoandisbursementRepositoryInterface
{
    public function fetchPaginatedLoanDisbursements();
    public function getPaginatedLoanDisbursementByBookingId($booking_id);
    public function saveLoan(array $request);
}
