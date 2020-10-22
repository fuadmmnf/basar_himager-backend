<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function downloadReport()
    {
        $salaries = $this->employeeSalaryRepository->fetchAllSalaries();
        $pdf = PDF::loadView('salary_report',[
            'salaries' => $salaries,
        ]);
//        return $pdf->stream();
        return $pdf->downloa('employees_salary_report');
    }
}
