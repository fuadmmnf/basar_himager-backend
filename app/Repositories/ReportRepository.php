<?php


namespace App\Repositories;

use App\Models\Bank;
use App\Models\Dailyexpense;
use App\Models\Bankdeposit;
use App\Models\Booking;
use App\Models\Delivery;
use App\Models\Employeeloan;
use App\Models\Gatepass;
use App\Models\Employeesalary;
use App\Models\Inventory;
use App\Models\Loaddistribution;
use App\Models\Loancollection;
use App\Models\Loandisbursement;
use App\Models\Expensecategory;
use App\Models\Receive;
use App\Models\Transaction;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use Carbon\Carbon;
use App\Models\Client;


class ReportRepository implements ReportRepositoryInterface
{
    public function fetchAllSalaries($month)
    {
        // TODO: Implement fetchAllSalaries() method.
        $salaries = Employeesalary::whereMonth('salary_month', Carbon::parse($month))
            ->with('employee')->get();
        foreach ($salaries as $salary)
        {
            $salary->loan_taken = Employeeloan::where('employee_id', $salary->employee->id)
            ->whereMonth('payment_time', Carbon::parse($month))
            ->where('type', 0)->sum('amount');
            $salary->loan_returned = Employeeloan::where('employee_id', $salary->employee->id)
                ->whereMonth('payment_time', Carbon::parse($month))
                ->where('type', 1)->sum('amount');
        }
        return $salaries;
    }

    public function getDeposits($month)
    {
        // TODO: Implement getDeposits() method.
        $deposits = Bankdeposit::whereMonth('created_at', Carbon::parse($month))->with('bank')->get();
        return $deposits;
    }

    public function getBanks()
    {
        // TODO: Implement getBanks() method.
        $banks = Bank::orderBy('name', 'asc')->get();
        return $banks;
    }

    public function fetchDailyexpenses($month)
    {
        $expensecategories = Expensecategory::where('category', null)->orderBy('type')->get();
        $expenses = Dailyexpense::whereMonth('date', Carbon::parse($month))->with('expensecategory')->get();

        foreach ($expensecategories as $expensecategory) {
            $cost = 0;
            foreach ($expenses as $e) {
                if ($expensecategory->type == $e->expensecategory->type) {
                    $cost = $e->amount + $cost;
                }
            }
            $expensecategory->amount = $cost;

        }
        return $expensecategories;
    }

    public function fetchBookingReceiptInfo($id)
    {
        // TODO: Implement fetchBookingReceiptInfo() method.
        $booking = Booking::where('id',$id)
            ->with('client')
            ->first();
        return $booking;
    }

    public function fetchReceiveReceiptInfo($id)
    {
        $receives = Receive::where('id', $id)
            ->with('booking')
            ->with('booking.client')
            ->with('receiveitems')->first();
//        $receives = Receive::
//            with('booking')
//            ->with('booking.client')->get();
        return $receives;
    }

    public function fetchDeliveryReceiptInfo($id)
    {
        $delivery = Delivery::where('id',$id)
            ->with('booking')
            ->with('booking.client')
            ->with('deliveryitems')->first();
        return $delivery;
    }


    public function fetchLoanDisbursementInfo($id)
    {
        // TODO: Implement fetchLoanDisbursementInfo() method.
        $loanDisbursements = Loandisbursement::where('id',$id)->first();
        $loanDisbursements->load('booking', 'booking.client', 'loancollections');
        return $loanDisbursements;
    }

    public function fetchLoanCollectionInfo($id)
    {
        // TODO: Implement fetchLoanCollectionInfo() method.
        $loanCollection = Loancollection::where('id',$id)->first();
        $loanCollection->load('loandisbursement', 'loandisbursement.booking.client');
        return $loanCollection;
    }
//    public function fetchReceiveReceiptInfo($id)
//    {
//        $receives = Receive::where('id',$id)
//            ->with('booking')
//            ->with('booking.client')->first();
////        $receives = Receive::
////            with('booking')
////            ->with('booking.client')->get();
//        return $receives;
//    }


    public function fetchGatepass($delivey_id)
    {
        // TODO: Implement fetchGatepass() method.
        $gatepass = Gatepass::where('delivery_id', $delivey_id)
            ->with('delivery')
            ->with('delivery.booking')
            ->with('delivery.booking.client')
            ->with('delivery.deliveryitems')->first();
        return $gatepass;
    }

    public function fetchAccountingInformation($start_date, $end_date): array
    {
        $transactions = Transaction::whereDate('time', '>=', Carbon::parse($start_date))
            ->whereDate('time', '<=', Carbon::parse($end_date))
            ->get();

        $transactionsSum = [];
        foreach ($transactions as $transaction){
            if (isset($transactionsSum[$transaction->remark])){
                $transactionsSum[$transaction->remark]['amount'] += $transaction->amount;
            } else {
                $transactionsSum[$transaction->remark] = [
                    'type' => $transaction->type,
                    'amount' => $transaction->amount
                ];
            }
        }

        return $transactionsSum;
    }


    public function downloadStorePotatoReceipt($client_id, $date)
    {
        $temp_date = Carbon::parse($date);
        // TODO: Implement downloadStorePotatoReceipt() method.
        $client = Client::where('id',$client_id)->with('bookings')
            ->with('bookings.receives')
            ->with('bookings.receives.receiveitems')
            ->first();
        $client->report_date = $temp_date;

        foreach ($client->bookings as $booking){
            foreach ($booking->receives as $receive){
                $receive->loaddistributions = Loaddistribution::where('receive_id',$receive->id)->whereDate('created_at',$temp_date)->get();
            }
        }

        foreach ($client->bookings as $booking){
            foreach ($booking->receives as $receive){
                foreach ($receive->loaddistributions as $loads ){
                    $loads->inventory = $this->fetchFullInventoryWithParentBYId($loads->compartment_id);
                }
            }
        }
        return $client;
    }

    private function fetchFullInventoryWithParentBYId($id){
        $inventory = Inventory::where('id',$id)->first();
        $this->getFullInventoryDecisionWithParent($inventory);
        return $inventory;
    }

    private function getFullInventoryDecisionWithParent($inventory){
        if($inventory->parent_id !== null){
            $temp= Inventory::where('id', $inventory->parent_id)->first();
            $inventory->parent_info = $temp;
            $this->getFullInventoryDecisionWithParent($inventory->parent_info);
        }
        return $inventory;
    }
}


