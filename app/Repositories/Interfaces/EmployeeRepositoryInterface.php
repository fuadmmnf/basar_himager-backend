<?php


namespace App\Repositories\Interfaces;


interface EmployeeRepositoryInterface
{
    public function createEmployee(array $request);
    public function getEmployeesByRole($role);

}
