<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Inventory\Chamber\CreateChamberEntryRequest;
use App\Repositories\Interfaces\ChamberentryRepositoryInterface;
use App\Repositories\Interfaces\ChamberRepositoryInterface;


class ChamberentryController extends ApiController
{
    //
    private $chamberentryRepository;

    public function __construct(ChamberentryRepositoryInterface $chamberentryRepository)
    {
        $this->middleware('auth:api');
        $this->chamberentryRepository = $chamberentryRepository;
    }



    public function fetchChamberentriesByChamber($chamber_id)
    {
        $chamberentries = $this->chamberentryRepository->getChamberEntriesByChamber($chamber_id);
        return response()->json($chamberentries);
    }

    public function createChamberentry(CreateChamberEntryRequest $request)
    {
        $chamberentry = $this->chamberentryRepository->saveChamberStageChange($request->validated());
        return response()->json($chamberentry, 201);
    }
}
