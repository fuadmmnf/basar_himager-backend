<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\BankTransactionRequest;
use App\Http\Requests\Bank\CreateBankRequest;
use App\Http\Requests\Machinepart\CreateMachinepartEntriesRequest;
use App\Http\Requests\Machinepart\CreateMachinepartRequest;
use App\Repositories\Interfaces\BankRepositoryInterface;
use App\Repositories\Interfaces\MachinepartRepositoryInterface;
use Illuminate\Http\Request;

class MachinepartController extends Controller
{
    //
    private $machinepartRepository;

    public function __construct(MachinepartRepositoryInterface $machinepartRepository)
    {
        $this->machinepartRepository = $machinepartRepository;
    }

    public function createMachinepart(CreateMachinepartRequest $request)
    {
        $machinepart = $this->machinepartRepository->saveMachinepart($request->validated());
        return response()->json($machinepart, 201);
    }

    public function createMachinepartEntries(CreateMachinepartEntriesRequest $request)
    {
        $machinepartentry = $this->machinepartRepository->saveMachinepartEntries($request->validated());
        return response()->json($machinepartentry, 201);
    }
}
