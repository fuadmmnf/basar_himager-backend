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
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $this->reportRepository = $reportRepository;
    }

//
//    public function downloadLoadingReport($receive_no)
//    {
//        $receiveRepository = new ReceiveRepository();
//        $pdf = PDF::loadView('loading_receipt', [
//            'receive' => $receiveRepository->getReceiveDetails($receive_no),
//        ]);
//        return $pdf->stream();
//    }

    public function downloadGatepass($gatepass_no)
    {
        $deliveryRepository = new DeliveryRepository();
        $pdf = PDF::loadView('gatepass_receipt', [
            'receive' => $deliveryRepository->getGatepassDetails($gatepass_no),
        ]);
        return $pdf->stream();
    }

    public function getLoaddistributionReport($receive_group_id)
    {
        $loaddistributionRepository = new LoaddistributionRepository();
        $pdf = PDF::loadView('loaddistribution', [
            'receives' => $loaddistributionRepository->getLoadDistributionsByReceive($receive_group_id),
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

    public function getReceivesReceipt($receivegroup_id)
    {
        $receiptinfo = $this->reportRepository->fetchReceiveReceiptInfo($receivegroup_id);
        $pdf = PDF::loadView('receive_receipt', [
            'receiptinfo' => $receiptinfo
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function getDeliveriesReceipt($deliverygroup_id)
    {
        $receiptinfo = $this->reportRepository->fetchDeliveryReceiptInfo($deliverygroup_id);
        $pdf = PDF::loadView('delivery_receipt', [
            'booking' => ((count($receiptinfo->deliveries) > 0) ? $receiptinfo->deliveries[0]->booking : $receiptinfo->loancollection[0]->loandisbursement->booking),
            'receiptinfo' => $receiptinfo
        ]);
//        , [], ['format' => 'A5-L']
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function getBookingReceipt($id)
    {
        $bookinginfo = $this->reportRepository->fetchBookingReceiptInfo($id);
        $pdf = PDF::loadView('booking_receipt', [
            'bookinginfo' => $bookinginfo
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function getBookingDetailsReport($id)
    {
        $bookingdetails = $this->reportRepository->fetchBookingDetailsInfo($id);
        $pdf = PDF::loadView('booking_details', [
            'bookinginfo' => $bookingdetails
        ]);
        return $pdf->stream();
    }

    public function getLoandisbursementReport($id)
    {
        $loandisbursement = $this->reportRepository->fetchLoanDisbursementInfo($id);
        $pdf = PDF::loadView('loandisbursement_report', [
            'loandisbursement' => $loandisbursement
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function getLoandisbursmentReportByClientId($client_id)
    {
        $clientInfoForLoandisbursments = $this->reportRepository->fetchLoanDisbursementInfoByClientId($client_id);
        $pdf = PDF::loadView('loandisbursments_report_by_client', [
            'clientInfo' => $clientInfoForLoandisbursments
        ]);
        return $pdf->stream();
    }

    public function getDateWiseLoandisbursmentReportByClientId($client_id, $start_date, $end_date)
    {
        $loandisbursements = $this->reportRepository->fetchDateWiseLoanDisbursementInfoByClientId($client_id, $start_date, $end_date);
        $pdf = PDF::loadView('date_wise_loandisbursments_report_by_client', [
            'infos' => $loandisbursements['infos'],
            'client' => $loandisbursements['client'],
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
        return $pdf->stream();
    }

    public function getLoancollectionReceipt($id)
    {
        $loancollection = $this->reportRepository->fetchLoanCollectionInfo($id);
        $pdf = PDF::loadView('loancollection_receipt', [
            'loancollection' => $loancollection
        ]);
        return $pdf->stream();
        //return $pdf->download('bank_deposit_report');
    }

    public function getGatePass($deliverygroup_id)
    {
        $gatePass = $this->reportRepository->fetchGatepass($deliverygroup_id);
        $pdf = PDF::loadView('gatepass_receipt', [
            'gatepassInfo' => $gatePass
        ]);
        return $pdf->stream();
    }

    public function downloadStorePotatoReceipt($client_id, $date)
    {
        $client = $this->reportRepository->downloadStorePotatoReceipt($client_id, $date);
        $pdf = PDF::loadView('store_potato_receipt', [
            'client' => $client
        ]);
        return $pdf->stream();
    }


    public function downloadAccountingReport($start_date, $end_date)
    {
        try {
            $transactions = $this->reportRepository->fetchAccountingInformation($start_date, $end_date);
        } catch (\Exception $e) {
            dd($e->getMessage());
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

    public function downloadReceiveReportInRange($start_date, $end_date)
    {
        try {
            $receivegroups = $this->reportRepository->fetchReceivesInformation($start_date, $end_date);
        } catch (\Exception $e) {
            dd("Please Provide Appropriate Date");
        }
        $total = 0;
        foreach ($receivegroups as $receivegroup) {
            foreach ($receivegroup->receives as $receive) {
                foreach ($receive->receiveitems as $item) {
                    $total += $item->quantity;
                }
            }
        }
        $pdf = PDF::loadView('receive_report', [
            'receivegroups' => $receivegroups,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total' => $total
        ]);
        return $pdf->stream();
    }

    public function downloadFanchargeReportInRange($start_date, $end_date)
    {

        try {
            $fancharges = $this->reportRepository->fetchFanchargeInformation($start_date, $end_date);
        } catch (\Exception $e) {
            dd("Please Provide Appropriate Date");
        }
        $total = 0;
        foreach ($fancharges as $fancharge) {
            $total += $fancharge->total_amount;
        }

        $pdf = PDF::loadView('fancharge_report', [
            'fancharges' => $fancharges,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total' => $total
        ]);
        return $pdf->stream();
    }

    public function downloadDailyStatementReport($start_date)
    {
        try {
            $statements = $this->reportRepository->fetchDailyStatements($start_date);
        } catch (\Exception $e) {
            dd("Please Provide Appropriate Date");
        }


        $pdf = PDF::loadView('dailystatements', [
            'statements' => $statements,
            'start_date' => $start_date,

        ]);
        return $pdf->stream();
    }

    public function downloadDeliveriesTyped($type, $start_date, $end_date)
    {
        try {
            $statements = $this->reportRepository->fetchDeliveryTyped($start_date, $end_date);
        } catch (\Exception $e) {
            dd("Please Provide Appropriate Date");
        }


        if ($type == 2) {
            $pdf = PDF::loadView('deliveries', [
                'statements' => $statements,
                'start_date' => $start_date,
            ]);
        } else {
            $pdf = PDF::loadView('deliveries_typed', [
                'statements' => $statements,
                'start_date' => $start_date,
                'type' => $type
            ]);
        }
        return $pdf->stream();
    }

    public function downloadStorePotatoReportByDate($start_date, $end_date)
    {
        $loaddistributions = $this->reportRepository->fetchLoadDistributions($start_date, $end_date);
        $pdf = PDF::loadView('loaddistribution_by_range', [
            'loaddistributions' => $loaddistributions
        ]);
        return $pdf->stream();
    }
}
