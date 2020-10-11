<?php

namespace App\Http\Controllers\Api;

use \App\Http\Controllers\Controller;
use App\Http\Requests\Receive\CreateReceiveRequest;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;


class ReceiveController extends Controller{

    private $receiveRepository;

    /**
     * receiveController constructor.
     */
    public function __construct(ReceiveRepositoryInterface $receiveRepository)
    {
        $this->receiveRepository = $receiveRepository;
    }

    public function createReceive(CreatereceiveRequest $request){

        $receive = $this->receiveRepository->saveReceive($request->validated());
        return response()->json($receive, 201);
    }
}
