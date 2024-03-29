<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Bank\BankTransactionRequest;
use App\Http\Requests\Bank\CreateBankRequest;
use App\Repositories\Interfaces\BankRepositoryInterface;
use Illuminate\Http\Request;

class BankController extends ApiController
{
    //
    private $bankRepository;

    public function __construct(BankRepositoryInterface $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    public function addBank(CreateBankRequest $request){
        $bank = $this->bankRepository->createBank($request->validated());
        return response()->json($bank, 201);
    }
    public function getAllBanks() {
        $banks = $this->bankRepository->getBanks();
        return response()->json($banks,200);
    }

    public function storeBankDeposit(BankTransactionRequest $request) {
        $deposit = $this->bankRepository->addBankDeposit($request->validated());
        if(!$deposit){
            return response()->json('withdraw limit exceeded', 400);
        }
        return response()->json($deposit, 201);
    }

    public function fetchBankDepositsByType($type) {
        $deposits = $this->bankRepository->getDeposits($type);
        return response()->json($deposits,200);
    }
}
