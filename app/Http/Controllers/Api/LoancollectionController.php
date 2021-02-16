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


    public function fetchPaginatedLoanCollectionByBookingID($booking_id)
    {
        $collections = $this->loancollectionRepository->getPaginatedLoanCollectionByBookingId($booking_id);

        return response()->json($collections, 201);
    }

    public function createLoancollection(CreateLoancollectionRequest $request){

        $loancollection = $this->loancollectionRepository->saveLoancollection($request->validated());
        if(!$loancollection){
            return response()->json('Amount exceeding loan left', 400);
        }
        return response()->json($loancollection, 201);
    }
}

