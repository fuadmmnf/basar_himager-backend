<?php

namespace App\Http\Controllers;

use App\Models\Receive;
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




    public function downloadSalaryReport($month)
    {
        $salaries = $this->reportRepository->fetchAllSalaries($month);
        $pdf = PDF::loadView('salary_report', [
            'salaries' => $salaries,
        ]);
        return $pdf->stream();
        //return $pdf->download('employees_salary_report');
    }

    public function downloadBankDepositReport($month)
    {
        $deposits = $this->reportRepository->getDeposits($month);
        $pdf = PDF::loadView('bankdeposit_report', [
            'deposits' => $deposits,
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

}
