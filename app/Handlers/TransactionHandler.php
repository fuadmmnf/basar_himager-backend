<?php


namespace App\Handlers;


use App\Models\Transaction;
use Carbon\Carbon;

class TransactionHandler
{
    public function createTransaction($transactionType, $amount, Carbon $dateTime, $relatedModel, $remark){
        $newTransaction = new Transaction();
        $newTransaction->model_name = get_class($relatedModel);
        $newTransaction->model_id = $relatedModel->id;
        $newTransaction->type = $transactionType;
        $newTransaction->amount = $amount;
        $newTransaction->time = $dateTime;
        $newTransaction->remark = $remark;
        $newTransaction->save();
    }
}
