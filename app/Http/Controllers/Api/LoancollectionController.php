<?php

namespace App\Http\Controllers\Api;

use \App\Http\Controllers\Controller;
use App\Http\Requests\Loan\CreateLoancollectionRequest;
use App\Repositories\Interfaces\LoancollectionRepositoryInterface;


class LoancollectionController extends Controller{

    private $loancollectionRepository;

    /**
     * LoancollectionController constructor.
     */
    public function __construct(LoancollectionRepositoryInterface $loancollectionRepository)
    {
        $this->loancollectionRepository = $loancollectionRepository;
    }

    public function createLoancollection(CreateLoancollectionRequest $request){

        $Loan = $this->loancollectionRepository->saveLoancollection($request->validated());
        return response()->json($Loan, 201);
    }
}
