<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Employee\StoreEmployeeSalaryRequest;
use App\Repositories\Interfaces\EmployeeSalaryRepositoryInterface;
use PDF;

class EmployeeSalaryController extends ApiController
{
    private $employeeSalaryRepository;

    /**
     * EmployeeController constructor.
     */
    public function __construct(EmployeeSalaryRepositoryInterface $employeeSalaryRepository)
    {
        $this->employeeSalaryRepository = $employeeSalaryRepository;
    }
    public function getAllSalaries()
    {
        $salaries = $this->employeeSalaryRepository->fetchAllSalaries();
        return view('salary_report')->with('salaries', $salaries);
    }

    public function getSalaryByEmployeeId($employee_id){
        $salary = $this->employeeSalaryRepository->fetchEmployeeSalaryByid($employee_id);
        return response()->json($salary,200);
    }

    public function storeEmployeeSalary(StoreEmployeeSalaryRequest $request)
    {
        $salary = $this->employeeSalaryRepository->storeEmployeeSalary($request->validated());
        if(!$salary){
            return response()->json('Loan Payment exceeding Salary', 400);
        }
        return response()->json($salary, 201);
    }

    public function getTotalAdvanceSalary($employee_id){
        $advance = $this->employeeSalaryRepository->getAdvanceSalary($employee_id);
        return response()->json($advance, 200);

    }
}
