<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Inventory\load\CreateloaddistributionRequest;
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

    public function createLoadDistribution(CreateloaddistributionRequest $request){
            $load = $this->loaddistributionRepository->saveLoaddistrbution($request->validated());
            return response()->json($load, 201);
    }

    public function getloaddistributionByReceive($receive_id){
        $load = $this->loaddistributionRepository->getLoadDistributionsByReceive($receive_id);
        return response()->json($load,200);
    }

    public function getloaddistributionDatesByClient($client_id){
        $load = $this->loaddistributionRepository->getLoadDistributionDatesByClient($client_id);
        return response()->json($load,200);
    }



    public function fetchLoaddistributionByBooking($booking_id){
        $load = $this->loaddistributionRepository->getLoadDistrbutionByBooking($booking_id);
        return response()->json($load,200);
    }

}

