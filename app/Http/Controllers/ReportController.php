<?php

namespace App\Http\Controllers;

use App\Repositories\DeliveryRepository;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Repositories\LoaddistributionRepository;
use App\Repositories\ReceiveRepository;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    private $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }


    public function downloadLoadingReport($receive_no)
    {
        $receiveRepository = new ReceiveRepository();
        $pdf = PDF::loadView('loading_receipt', [
            'receive' => $receiveRepository->getReceiveDetails($receive_no),
        ]);
        return $pdf->stream();
    }

    public function downloadGatepass($gatepass_no)
    {
        $deliveryRepository = new DeliveryRepository();
        $pdf = PDF::loadView('gatepass_receipt', [
            'receive' => $deliveryRepository->getGatepassDetails($gatepass_no),
        ]);
        return $pdf->stream();
    }

    public function getLoaddistributionReport($receive_id){
        $loaddistributionRepository = new LoaddistributionRepository();
        $pdf = PDF::loadView('loaddistribution', [
            'loads' => $loaddistributionRepository->getLoadDistributions($receive_id),
        ]);
        return $pdf->stream();
    }

    public function downloadSalaryReport($month)
    {
        $salaries = $this->reportRepository->fetchAllSalaries($month);
        $pdf = PDF::loadView('salary_report', [
            'salaries' => $salaries,
            'month' => $month,
        ]);
        return $pdf->stream();
        //return $pdf->download('employees_salary_report');
    }

    public function downloadBankDepositReport($month)
    {
        $deposits = $this->reportRepository->getDeposits($month);

        $banks = $this->reportRepository->getBanks();
        $pdf = PDF::loadView('bankdeposit_report', [
            'deposits' => $deposits,
            'banks' => $banks,
            'month' => $month
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function downloadExpenseReport($month)
    {
        $expenses = $this->reportRepository->fetchDailyexpenses($month);
        $pdf = PDF::loadView('expense_report', [
            'expenses' => $expenses,
            'month' => $month
        ]);
        return $pdf->stream();
    }

    public function getReceiveReceipt($id)
    {
        $receiptinfo = $this->reportRepository->fetchReceiveReceiptInfo($id);
        $pdf = PDF::loadView('receive_receipt', [
            'receiptinfo' => $receiptinfo
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function getDeliveryReceipt($id)
    {
        $receiptinfo = $this->reportRepository->fetchDeliveryReceiptInfo($id);
        $pdf = PDF::loadView('delivery_receipt',[
            'receiptinfo' => $receiptinfo
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function getBookingReceipt($id)
    {
        $bookinginfo = $this->reportRepository->fetchBookingReceiptInfo($id);
        $pdf = PDF::loadView('booking_receipt',[
            'bookinginfo' => $bookinginfo
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }
    public function getLoandisbursementReport($id)
    {
        $loandisbursement = $this->reportRepository->fetchLoanDisbursementInfo($id);
        $pdf = PDF::loadView('loandisbursement_report',[
            'loandisbursement' => $loandisbursement
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function getLoancollectionReceipt($id)
    {
        $loancollection = $this->reportRepository->fetchLoanCollectionInfo($id);
        $pdf = PDF::loadView('loancollection_receipt',[
            'loancollection' => $loancollection
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function getGatePass($delivery_id)
    {
        $gatePass = $this->reportRepository->fetchGatepass($delivery_id);
        $pdf = PDF::loadView('gatepass_receipt', [
            'gatepassInfo' => $gatePass
        ]);
        return $pdf->stream();
    }

    public function downloadStorePotatoReceipt($client_id,$date){
        $client = $this->reportRepository->downloadStorePotatoReceipt($client_id,$date);
        $pdf = PDF::loadView('store_potato_receipt',[
            'client' => $client
        ]);
        return $pdf->stream();
    }


    public function downloadAccountingReport($start_date, $end_date)
    {
        try {
            $transactions = $this->reportRepository->fetchAccountingInformation($start_date, $end_date);
        } catch (\Exception $e) {
            dd("Please Provide Appropriate Date");
        }


        $pdf = PDF::loadView('accounting', [
            'expenses' => array_filter($transactions, function ($transaction) {
                return $transaction['type'] == 1;
            }),
            'incomes' => array_filter($transactions, function ($transaction) {
                return $transaction['type'] == 0;
            }),
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
        return $pdf->stream();
    }
}
