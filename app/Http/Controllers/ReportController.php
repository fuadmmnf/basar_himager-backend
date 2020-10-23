<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ReportRepositoryInterface;
use PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }
    public function downloadReport()
    {
        $salaries = $this->reportRepository->fetchAllSalaries();
        $pdf = PDF::loadView('salary_report',[
            'salaries' => $salaries,
        ]);
        return $pdf->stream();
        //return $pdf->download('employees_salary_report');
    }
}
