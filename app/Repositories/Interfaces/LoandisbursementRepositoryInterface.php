<?php


namespace App\Repositories\Interfaces;


interface LoandisbursementRepositoryInterface
{
    public function fetchPaginatedLoanDisbursements();
    public function saveLoan(array $request);
}
