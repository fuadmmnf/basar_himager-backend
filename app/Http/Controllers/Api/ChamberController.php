<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chamber\CreateChamberEntryRequest;
use App\Repositories\Interfaces\ChamberRepositoryInterface;


class ChamberController extends Controller
{
    //
    private $chamberRepository;

    public function __construct(ChamberRepositoryInterface $chamberRepository)
    {
        $this->middleware('auth:api');
        $this->chamberRepository = $chamberRepository;
    }


    public function fetchChambers()
    {
        $chambers = $this->chamberRepository->getChambers();
        return response()->json($chambers);
    }

    public function fetchChamberentries()
    {
        $chamberentries = $this->chamberRepository->getChamberEntries();
        return response()->json($chamberentries);
    }

    public function createChamberentry(CreateChamberEntryRequest $request)
    {
        $chamberentry = $this->chamberRepository->saveChamberStageChange($request->validated());
        return response()->json($chamberentry, 201);
    }
}
