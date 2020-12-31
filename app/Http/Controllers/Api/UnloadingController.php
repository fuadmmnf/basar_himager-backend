<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Inventory\unloading\CreateUnloadingRequest;
use App\Repositories\Interfaces\UnloadingRepositoryInterface;

class UnloadingController extends ApiController{

    private $unloadingRepository;

    public function __construct(UnloadingRepositoryInterface $unloadingRepository)
    {
        $this->unloadingController = $unloadingRepository;
    }

    public function saveUnloading(CreateUnloadingRequest $request){
        $unloads=$this->unloadingRepository->createUnloadingEntry($request->validated());
        return response()->json($unloads, 201);

    }
}
