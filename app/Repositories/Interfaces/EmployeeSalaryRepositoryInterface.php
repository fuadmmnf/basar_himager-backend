<?php


namespace App\Repositories\Interfaces;


interface EmployeeSalaryRepositoryInterface
{
    public function fetchAllSalaries();
    public function storeEmployeeSalary(array $request);
    public function getAdvanceSalary($employee_id);
}
