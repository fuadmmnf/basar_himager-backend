<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeSalaryRequest;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
    public function storeEmployeeSalary(StoreEmployeeSalaryRequest $request)
    {
        $salary = $this->employeeRepository->storeEmployeeSalary($request->validated());
        return response()->json($salary, 201);
    }
}
