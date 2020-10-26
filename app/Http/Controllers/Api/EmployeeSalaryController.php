<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeSalaryRequest;
use App\Repositories\Interfaces\EmployeeSalaryRepositoryInterface;
use PDF;

class EmployeeSalaryController extends Controller
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

    public function storeEmployeeSalary(StoreEmployeeSalaryRequest $request)
    {
        $salary = $this->employeeSalaryRepository->storeEmployeeSalary($request->validated());
        return response()->json($salary, 201);
    }
}
