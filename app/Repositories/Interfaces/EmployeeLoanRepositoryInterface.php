<?php


namespace App\Repositories\Interfaces;


interface EmployeeLoanRepositoryInterface
{
    public function createEmployeeLoan(array $request);
    public function getEmployeeLoan($employee_id);
}
