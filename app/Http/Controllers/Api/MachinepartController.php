<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Machinepart\CreateMachinepartEntriesRequest;
use App\Http\Requests\Machinepart\CreateMachinepartRequest;
use App\Repositories\Interfaces\MachinepartRepositoryInterface;
use Illuminate\Http\Request;

class MachinepartController extends ApiController
{
    //
    private $machinepartRepository;

    public function __construct(MachinepartRepositoryInterface $machinepartRepository)
    {
        $this->middleware('auth:api');
        $this->machinepartRepository = $machinepartRepository;
    }

    public function fetchMachineparts()
    {
        $machineparts = $this->machinepartRepository->getMachineparts();
        return response()->json($machineparts);
    }

    public function fetchMachinepartEntries()
    {
        $machinepartentries = $this->machinepartRepository->getMachinepartEntries();
        return $machinepartentries;
    }

    public function createMachinepart(CreateMachinepartRequest $request)
    {
        $machinepart = $this->machinepartRepository->saveMachinepart($request->validated());
        return response()->json($machinepart, 201);
    }

    public function createMachinepartEntries(CreateMachinepartEntriesRequest $request)
    {
        $machinepartentry = $this->machinepartRepository->saveMachinepartEntries($request->validated());
        if(!$machinepartentry){
            return response()->json('usage limit exceeded', 400);
        }
        return response()->json($machinepartentry, 201);
    }
}
