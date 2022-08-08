<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Deliverygroup;
use App\Models\Loancollection;
use App\Models\Loandisbursement;
use App\Repositories\Interfaces\LoancollectionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LoancollectionRepository implements LoancollectionRepositoryInterface
{

    public function getPaginatedLoanCollectionByBookingId($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $collections = $booking->loanCollections()->paginate(15);
        return $collections;
    }


    public function saveLoancollection(array $request)
    {
        $loandisbursement = Loandisbursement::findOrFail($request['loandisbursement_id']);

        if($loandisbursement->amount_left < $request['payment_amount']){
            return null;
        }

        $deliveryGroup = new Deliverygroup();
        $deliveryGroup->delivery_time = Carbon::parse($request['payment_date'])->setTimezone('Asia/Dhaka');;
        $deliveryGroup->delivery_year = Carbon::parse($request['delivery_time'])->setTimezone('Asia/Dhaka')->year;
        $deliveryGroup->delivery_no =  sprintf('%04d', Deliverygroup::whereYear('delivery_time', $deliveryGroup->delivery_time)->count() + 1) . $deliveryGroup->delivery_time->year % 100;
        $deliveryGroup->type = 1;
        $deliveryGroup->save();

        $newLoancollection = new Loancollection();
        $newLoancollection->loandisbursement_id = $loandisbursement->id;
        $newLoancollection->deliverygroup_id = $deliveryGroup->id;
        $newLoancollection->loancollection_no = Str::random(8);
        $newLoancollection->surcharge = $request['surcharge'];
        $newLoancollection->service_charge_rate = $request['service_charge_rate'];
        $newLoancollection->payment_amount = $request['payment_amount'];
        $newLoancollection->pending_loan_amount = $request['pending_loan_amount'];
        $newLoancollection->payment_date = Carbon::parse($request['payment_date'])->setTimezone('Asia/Dhaka');
        $newLoancollection->save();

        $loandisbursement->amount_left = $loandisbursement->amount_left - $newLoancollection->payment_amount;
        $loandisbursement->save();

        return $newLoancollection;
    }
}
