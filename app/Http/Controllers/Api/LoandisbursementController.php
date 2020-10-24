<?php

namespace App\Http\Controllers\Api;

use \App\Http\Controllers\Controller;
use App\Http\Requests\Loan\CreateLoandisbursementRequest;
use App\Repositories\Interfaces\LoandisbursementRepositoryInterface;


class LoandisbursementController extends Controller{

    private $loandisbursementRepository;

    /**
     * LoandisbursementController constructor.
     */
    public function __construct(LoandisbursementRepositoryInterface $loandisbursementRepository)
    {
        $this->loandisbursementRepository = $loandisbursementRepository;
    }

    public function createLoan(CreateLoandisbursementRequest $request){

        $loanDisbursement = $this->loandisbursementRepository->saveLoan($request->validated());
        return response()->json($loanDisbursement, 201);
    }
}

