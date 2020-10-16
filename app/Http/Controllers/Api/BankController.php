<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\BankDepositRequest;
use App\Http\Requests\Bank\CreateBankRequest;
use App\Repositories\Interfaces\BankRepositoryInterface;
use Illuminate\Http\Request;

class BankController extends Controller
{
    //
    private $bankRepository;

    /**
     * EmployeeController constructor.
     */
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

    public function storeBankDeposit(BankDepositRequest $request) {
        $deposit = $this->bankRepository->addBankDeposit($request->validated());
        return response()->json($deposit, 201);
    }

    public function getBankDeposits() {
        $deposits = $this->bankRepository->getDeposits();
        return response()->json($deposits,200);
    }
}
