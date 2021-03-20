<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Receive\CreateReceiveRequest;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;


class ReceiveController extends ApiController
{

    private $receiveRepository;

    /**
     * receiveController constructor.
     */
    public function __construct(ReceiveRepositoryInterface $receiveRepository)
    {
        $this->middleware('auth:api');
        $this->receiveRepository = $receiveRepository;
    }

    public function fetchRecentReceives(){
        $receives = $this->receiveRepository->getRecentReceives();
        return response()->json($receives);
    }

    public function fetchReceivesByGroupId($id){
        $receive =$this->receiveRepository->getReceiveByGroupId($id);
        return response()->json($receive, 200);
    }

    public function fetchRecentReceiveGroups(){
        $receive_groups = $this->receiveRepository->getRecentReceiveGroups();
        return response()->json($receive_groups,200);
    }

    public function fetchPaginatedReceivesByBookingID($booking_id)
    {
        $receives = $this->receiveRepository->getPaginatedReceivesByBookingId($booking_id);

        return response()->json($receives, 200);
    }
    public function createReceivegroup(CreatereceiveRequest $request){

        $receive = $this->receiveRepository->saveReceivegroup($request->validated());
        if(!$receive){
            return response()->json('booking quantity limit exceeded', 400);
        }
        return response()->json($receive, 201);
    }
}
