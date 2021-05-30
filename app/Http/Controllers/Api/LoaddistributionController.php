<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Inventory\Load\CreateloaddistributionRequest;
use App\Http\Requests\Inventory\Load\CreatePalotRequest;
use App\Repositories\Interfaces\LoaddistributionRepositoryInterface;


class LoaddistributionController extends ApiController
{

    private $loaddistributionRepository;

    /**
     * LoancollectionController constructor.
     */
    public function __construct(LoaddistributionRepositoryInterface $loaddistributionRepository)
    {
        $this->loaddistributionRepository = $loaddistributionRepository;
    }


    public function getloaddistributionByReceive($receive_id){
        $load = $this->loaddistributionRepository->getLoadDistributionsByReceiveID($receive_id);
        return response()->json($load,200);
    }

    public function getloaddistributionDatesByClient($client_id){
        $load = $this->loaddistributionRepository->getLoadDistributionDatesByClient($client_id);
        return response()->json($load,200);
    }



    public function fetchPositionsByBooking($booking_id){
        $load = $this->loaddistributionRepository->getLoadPositionsByBooking($booking_id);
        return response()->json($load,200);
    }


    public function createLoadDistribution(CreateloaddistributionRequest $request){
        $load = $this->loaddistributionRepository->saveLoaddistrbution($request->validated());
        return response()->json($load, 201);
    }

    public function createPalot(CreatePalotRequest $request){
        $palot = $this->loaddistributionRepository->savePalot($request->validated());
        return response()->json($palot, 201);
    }


}

