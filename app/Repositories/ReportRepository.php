<?php


namespace App\Repositories;

use App\Handlers\InventoryHandler;
use App\Models\Bank;
use App\Models\Dailyexpense;
use App\Models\Bankdeposit;
use App\Models\Booking;
use App\Models\Delivery;
use App\Models\Deliverygroup;
use App\Models\Employeeloan;
use App\Models\Gatepass;
use App\Models\Employeesalary;
use App\Models\Inventory;
use App\Models\Loaddistribution;
use App\Models\Loancollection;
use App\Models\Loandisbursement;
use App\Models\Expensecategory;
use App\Models\Receive;
use App\Models\Receivegroup;
use App\Models\Transaction;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use Carbon\Carbon;
use App\Models\Client;


class ReportRepository implements ReportRepositoryInterface
{
    public function fetchAllSalaries($month)
    {
        // TODO: Implement fetchAllSalaries() method.
        $salaries = Employeesalary::whereMonth('salary_month', Carbon::parse($month)->setTimezone('Asia/Dhaka'))
            ->with('employee')->get();
        foreach ($salaries as $salary)
        {
            $salary->loan_taken = Employeeloan::where('employee_id', $salary->employee->id)
            ->whereMonth('payment_time', Carbon::parse($month)->setTimezone('Asia/Dhaka'))
            ->where('type', 0)->sum('amount');
            $salary->loan_returned = Employeeloan::where('employee_id', $salary->employee->id)
                ->whereMonth('payment_time', Carbon::parse($month)->setTimezone('Asia/Dhaka'))
                ->where('type', 1)->sum('amount');
        }
        return $salaries;
    }

    public function getDeposits($month)
    {
        // TODO: Implement getDeposits() method.
        $deposits = Bankdeposit::whereMonth('created_at', Carbon::parse($month)->setTimezone('Asia/Dhaka'))->with('bank')->get();
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
        $expenses = Dailyexpense::whereMonth('date', Carbon::parse($month)->setTimezone('Asia/Dhaka'))->with('expensecategory')->get();

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

    public function fetchBookingDetailsInfo($id)
    {
        $booking = Booking::where('id',$id)
            ->with('client', 'receives', 'deliveries', 'loanDisbursements', 'loanDisbursements.loancollections')
            ->first();
        return $booking;
    }

    public function fetchReceiveReceiptInfo($receivegroup_id)
    {
        $receivegroup = Receivegroup::findOrFail($receivegroup_id);
        $receivegroup->load('receives', 'receives.receiveitems', 'receives.booking', 'receives.booking.client');
        return $receivegroup;
    }

    public function fetchDeliveryReceiptInfo($deliverygroup_id)
    {
        $deliverygroup = Deliverygroup::findOrFail($deliverygroup_id);
        $deliverygroup->load('deliveries', 'deliveries.deliveryitems', 'deliveries.booking', 'deliveries.booking.client');
        return $deliverygroup;
    }


    public function fetchLoanDisbursementInfo($id)
    {
        // TODO: Implement fetchLoanDisbursementInfo() method.
        $loanDisbursements = Loandisbursement::where('id',$id)->first();
        $loanDisbursements->load('booking', 'booking.client', 'loancollections', 'loancollections.deliverygroup');
        return $loanDisbursements;
    }

    public function fetchLoanCollectionInfo($id)
    {
        // TODO: Implement fetchLoanCollectionInfo() method.
        $loanCollection = Loancollection::where('id',$id)->first();
        $loanCollection->load('loandisbursement', 'loandisbursement.booking.client', 'deliverygroup');
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


    public function fetchGatepass($deliverygroup_id)
    {
        // TODO: Implement fetchGatepass() method.
        $gatepass = Gatepass::where('deliverygroup_id', $deliverygroup_id)
            ->with('deliverygroup')
            ->with('deliverygroup.deliveries')
            ->with('deliverygroup.deliveries.booking')
            ->with('deliverygroup.deliveries.booking.client')
            ->with('deliverygroup.deliveries.deliveryitems')
            ->with('deliverygroup.deliveries.deliveryitems.unloadings')
            ->with('deliverygroup.deliveries.deliveryitems.unloadings.loaddistribution')
            ->with('deliverygroup.deliveries.deliveryitems.unloadings.loaddistribution.receive')
            ->first();
        $potatoArr = [];
        foreach ($gatepass->deliverygroup->deliveries as $delivery){
            foreach ($delivery->deliveryitems as $item){
                if(isset($potatoArr[$item->potato_type])){
                    $potatoArr[$item->potato_type] += $item->quantity;
                } else {
                    $potatoArr[$item->potato_type] = $item->quantity;
                }
            }
        }

        $lotArr = [];
        foreach ($gatepass->deliverygroup->deliveries as $delivery){
            foreach ($delivery->deliveryitems as $item) {
                foreach ($item->unloadings as $unloading) {
                    $lot = $unloading->loaddistribution->receive->lot_no;
                    if(isset($lotArr[$item->potato_type])){
                        if(!in_array($lot, $lotArr[$item->potato_type])){
                            array_push($lotArr[$item->potato_type], $lot);
                        }
                    } else {
                        $lotArr[$item->potato_type] = [$lot];
                    }

                }
            }

        }

        $gatepass->deliverygroup->potato_list = $potatoArr;
        $gatepass->deliverygroup->lot_list = $lotArr;
        return $gatepass;
    }

    public function fetchReceivesInformation($start_date, $end_date)
    {
        $receivegroups = Receivegroup::whereDate('receiving_time', '>=', Carbon::parse($start_date)->setTimezone('Asia/Dhaka'))
            ->whereDate('receiving_time', '<=', Carbon::parse($end_date)->setTimezone('Asia/Dhaka'))
            ->with('receives')
            ->with('receives.booking')
            ->with('receives.booking.client')
            ->with('receives.receiveitems')
            ->get();
        return $receivegroups;
    }

    public function fetchAccountingInformation($start_date, $end_date): array
    {
        $transactions = Transaction::whereDate('time', '>=', Carbon::parse($start_date)->setTimezone('Asia/Dhaka'))
            ->whereDate('time', '<=', Carbon::parse($end_date)->setTimezone('Asia/Dhaka'))
            ->get();
        $transactionsSum = [];
        $loanCollectionIds = [];
        $totalSurCharge = 0;
        foreach ($transactions as $transaction){
            if($transaction->model_name === "App\Models\Loancollection") {
                array_push($loanCollectionIds, $transaction->model_id);
            }
            if (isset($transactionsSum[$transaction->remark])){
                $transactionsSum[$transaction->remark]['amount'] += $transaction->amount;
            } else {
                $transactionsSum[$transaction->remark] = [
                    'type' => $transaction->type,
                    'amount' => $transaction->amount
                ];
            }
        }

        $loanCollections = Loancollection::whereIn('id', $loanCollectionIds)->get();
        foreach ($loanCollections as $lc) {
            $totalSurCharge += $lc->surcharge;
        }
        $transactionsSum['Booking Loan Collection Surcharge'] = [
            'type' => 0,
            'amount' => $totalSurCharge
        ];

        if(isset($transactionsSum['Booking Loan Collection'])){
            $transactionsSum['Booking Loan Collection']['amount'] -= $totalSurCharge;
        } else {
            $transactionsSum['Booking Loan Collection'] = [
                'type' => 0,
                'amount' => 0
            ];
        }
        return $transactionsSum;
    }


    public function downloadStorePotatoReceipt($client_id, $date)
    {
        $temp_date = Carbon::parse($date)->setTimezone('Asia/Dhaka');
        // TODO: Implement downloadStorePotatoReceipt() method.
        $client = Client::where('id', $client_id)
            ->with('bookings')
            ->with('bookings.receives')
            ->with('bookings.receives.receivegroup')
            ->with('bookings.receives.receiveitems')
            ->first();

        $client->report_date = $temp_date;

        foreach ($client->bookings as $booking){
            foreach ($booking->receives as $receive){
                $receive->loaddistributions = Loaddistribution::where('receive_id',$receive->id)->whereDate('created_at',$temp_date)->get();
            }
        }

        $inventoryHandler = new InventoryHandler();
        foreach ($client->bookings as $booking){
            foreach ($booking->receives as $receive){
                foreach ($receive->loaddistributions as $loads ){
                    $loads->inventory = $inventoryHandler->fetchFullInventoryWithParentBYId($loads->compartment_id);
                }
            }
        }
        return $client;
    }


    public function fetchLoanDisbursementInfoByClientId($client_id)
    {
        $clientInfoForLoandisbursments = Client::where('id',$client_id)->first();
        $clientInfoForLoandisbursments->load('bookings', 'bookings.loanDisbursements');
        return $clientInfoForLoandisbursments;
        // TODO: Implement fetchLoanDisbursementInfoByClientId() method.
    }

    public function fetchDateWiseLoanDisbursementInfoByClientId($client_id, $start_date, $end_date) {

        $client = Client::where('id',$client_id)->first();
        $client->load('bookings','bookings.loanDisbursements');
        $infos = [];
        $start = Carbon::parse($start_date)->setTimezone('Asia/Dhaka')->format('d-m-Y');
        $end = Carbon::parse($end_date)->setTimezone('Asia/Dhaka')->format('d-m-Y');
        foreach ($client->bookings as $booking) {
            foreach ($booking->loanDisbursements as $ld) {
                $payment_date = Carbon::parse($ld->payment_date)->setTimezone('Asia/Dhaka')->format('d-m-Y');
                $ld->booking_no = $booking->booking_no;
                if($payment_date >= $start && $payment_date <= $end) {
                    array_push($infos, $ld);
                }
            }
        }
        return ['client' => $client, 'infos' => $infos];
    }
    public function fetchDailyStatements($start_date) {
        $statements = Deliverygroup::whereDate('delivery_time', '>=', Carbon::parse($start_date)->setTimezone('Asia/Dhaka'))
            ->whereDate('delivery_time', '<=', Carbon::parse($start_date)->setTimezone('Asia/Dhaka'))
            ->get();

        $statements->load('deliveries', 'deliveries.deliveryitems', 'deliveries.booking', 'loancollection');

        return $statements;
    }

    public function fetchDeliveryTyped($start_date, $end_date) {
        $statements = Deliverygroup::whereDate('delivery_time', '>=', Carbon::parse($start_date)->setTimezone('Asia/Dhaka'))
            ->whereDate('delivery_time', '<=', Carbon::parse($end_date)->setTimezone('Asia/Dhaka'))
            ->get();

        $statements->load('deliveries', 'deliveries.deliveryitems', 'deliveries.booking', 'deliveries.deliveryitems.unloadings.loaddistribution', 'deliveries.deliverygroup.loancollection');

        return $statements;
    }

    public function fetchLoadDistributions($start_date, $end_date)
    {
        $loads = Loaddistribution::whereDate('created_at', '>=', Carbon::parse($start_date)->setTimezone('Asia/Dhaka'))
            ->whereDate('created_at', '<=', Carbon::parse($end_date)->setTimezone('Asia/Dhaka'))->get();
        $loads->load('receive','receive.booking');
        $inventoryHandler = new InventoryHandler();
        foreach ($loads as $loaddistribution) {
            $loaddistribution->inventory = $inventoryHandler->fetchFullInventoryWithParentById($loaddistribution->compartment_id);
        }

        return $loads;
    }
}


