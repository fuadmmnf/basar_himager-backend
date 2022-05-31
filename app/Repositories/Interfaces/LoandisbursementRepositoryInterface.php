<?php


namespace App\Repositories\Interfaces;


interface LoandisbursementRepositoryInterface
{
    public function fetchPaginatedLoanDisbursements($year);
    public function getPaginatedLoanDisbursementByBookingId($booking_id);
    public function saveLoan(array $request);
    public function fetchLoanByQuery($year, $query);
}
