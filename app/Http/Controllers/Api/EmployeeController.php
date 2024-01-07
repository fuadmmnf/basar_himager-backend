<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeSalaryRequest;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeController extends ApiController
{
    //
    private $employeeRepository;

    /**
     * EmployeeController constructor.
     */
    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function store(CreateEmployeeRequest $request){
        $employee = $this->employeeRepository->createEmployee($request->validated());
        return response()->json($employee, 201);
    }
    public function update($employee_id,CreateEmployeeRequest $request){
        $employee = $this->employeeRepository->editEmployee($employee_id ,$request->validated());
        return response()->json($employee, 201);
    }
    public function getAllEmployees()
    {
        $employees = $this->employeeRepository->getEmployees();
        return response()->json($employees, 200);
    }

    public function fetchEmployeesByRole($role)
    {
        $employees = $this->employeeRepository->getEmployeesByRole($role);

        return response()->json($employees, 200);
    }
    public function disableEmployee($employee_id)
    {
        $employees = $this->employeeRepository->disableEmployee($employee_id);

        return response()->json($employees, 200);
    }


}
