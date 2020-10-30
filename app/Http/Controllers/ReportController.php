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
    public function downloadSalaryReport($month)
    {
        $salaries = $this->reportRepository->fetchAllSalaries($month);
        $pdf = PDF::loadView('salary_report',[
            'salaries' => $salaries,
        ]);
        return $pdf->stream();
        //return $pdf->download('employees_salary_report');
    }

    public function downloadBankDepositReport($month) {
        $deposits = $this->reportRepository->getDeposits($month);
        $banks = $this->reportRepository->getBanks();
        $pdf = PDF::loadView('bankdeposit_report',[
            'deposits' => $deposits,
            'banks' => $banks,
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function downloadExpenseReport($month) {
        $expenses = $this->reportRepository->fetchDailyexpenses($month);
        $pdf = PDF::loadView('expense_report',[
            'expenses' => $expenses,
        ]);
        return $pdf->stream();
    }
}
