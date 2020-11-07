<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Loan\CreateLoancollectionRequest;
use App\Repositories\Interfaces\LoancollectionRepositoryInterface;


class LoancollectionController extends ApiController
{

    private $loancollectionRepository;

    /**
     * LoancollectionController constructor.
     */
    public function __construct(LoancollectionRepositoryInterface $loancollectionRepository)
    {
        $this->loancollectionRepository = $loancollectionRepository;
    }

    public function createLoancollection(CreateLoancollectionRequest $request){

        $loancollection = $this->loancollectionRepository->saveLoancollection($request->validated());
        return response()->json($loancollection, 201);
    }
}

