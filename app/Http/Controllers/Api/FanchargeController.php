<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Requests\Fancharge\CreateFanchargeRequest;
use App\Http\Requests\Settings\Potatotype\CreatePotatotypeRequest;
use App\Repositories\Interfaces\FanchargeRepositoryInterface;
use App\Repositories\Interfaces\PotatotypeRepositoryInterface;

class FanchargeController extends ApiController
{
    private $fanchargeRepository;

    public function __construct(FanchargeRepositoryInterface $fanchargeRepository)
    {
        $this->fanchargeRepository = $fanchargeRepository;
    }

    public function fetchFancharges(){
        $fancharges = $this->fanchargeRepository->getFancharges();
        return response()->json($fancharges, 200);
    }

    public function storeFancharge(CreateFanchargeRequest $request){
        $fancharges = $this->fanchargeRepository->storeFancharge($request->validated());
        return response()->json($fancharges, 201);
    }

}
