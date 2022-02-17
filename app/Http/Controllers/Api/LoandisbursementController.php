<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Loan\CreateLoandisbursementRequest;
use App\Repositories\Interfaces\LoandisbursementRepositoryInterface;
use Illuminate\Http\Request;


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


    public function fetchPaginatedLoanDisbursementByBookingID($booking_id)
    {
        $disbursements = $this->loandisbursementRepository->getPaginatedLoanDisbursementByBookingId($booking_id);

        return response()->json($disbursements, 200);
    }


    public function createLoan(CreateLoandisbursementRequest $request){

        $loanDisbursement = $this->loandisbursementRepository->saveLoan($request->validated());
        return response()->json($loanDisbursement, 201);
    }

    public function fetchLoandisbursements(Request $request){
        $loanDisbursements = $this->loandisbursementRepository->fetchPaginatedLoanDisbursements($request->query('selected_year'));
        return response()->json($loanDisbursements, 200);
    }
}

