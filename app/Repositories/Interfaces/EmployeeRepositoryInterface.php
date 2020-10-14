<?php


namespace App\Repositories\Interfaces;


interface EmployeeRepositoryInterface
{
    public function createEmployee(array $request);
    public function getEmployees();
    public function getEmployeesByRole($role);

}
