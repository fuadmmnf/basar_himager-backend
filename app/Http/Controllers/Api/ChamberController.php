<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Inventory\Chamber\CreateChamberEntryRequest;
use App\Repositories\Interfaces\ChamberRepositoryInterface;


class ChamberController extends ApiController
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

}
