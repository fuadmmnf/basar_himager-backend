<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Loan\CreateLoandisbursementRequest;
use App\Repositories\Interfaces\LoandisbursementRepositoryInterface;


class LoandisbursementController extends ApiController
{

    private $loandisbursementRepository;

    /**
     * LoandisbursementController constructor.
     */
    public function __construct(LoandisbursementRepositoryInterface $loandisbursementRepository)
    {
        $this->middleware('auth:api');
        $this->loandisbursementRepository = $loandisbursementRepository;
    }

    public function createLoan(CreateLoandisbursementRequest $request){

        $loanDisbursement = $this->loandisbursementRepository->saveLoan($request->validated());
        return response()->json($loanDisbursement, 201);
    }

    public function fetchLoandisbursements(){
        $loanDisbursements = $this->loandisbursementRepository->fetchPaginatedLoanDisbursements();
        return response()->json($loanDisbursements, 200);
    }
}

