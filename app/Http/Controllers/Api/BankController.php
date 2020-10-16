<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
