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
    public function downloadSalaryReport()
    {
        $salaries = $this->reportRepository->fetchAllSalaries();
        $pdf = PDF::loadView('salary_report',[
            'salaries' => $salaries,
        ]);
        return $pdf->stream();
        //return $pdf->download('employees_salary_report');
    }

    public function downloadBankDepositReport() {
        $deposits = $this->reportRepository->getDeposits();
        $pdf = PDF::loadView('bankdeposit_report',[
            'deposits' => $deposits,
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }
}
