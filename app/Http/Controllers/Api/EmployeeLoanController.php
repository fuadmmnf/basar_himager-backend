<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Employee\StoreEmployeeLoanRequest;
use App\Repositories\Interfaces\EmployeeLoanRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeLoanController extends ApiController
{
    private $employeeLoanRepository;

    public function __construct(EmployeeLoanRepositoryInterface $employeeLoanRepository)
    {
        $this->employeeLoanRepository = $employeeLoanRepository;
    }

    public function store(StoreEmployeeLoanRequest $request){
        $loan = $this->employeeLoanRepository->createEmployeeLoan($request->validated());
        return response()->json($loan, 201);
    }
    public function getLoan($employee_id){
        $loan = $this->employeeLoanRepository->getEmployeeLoan($employee_id);
        return response()->json($loan, 200);
    }
}
