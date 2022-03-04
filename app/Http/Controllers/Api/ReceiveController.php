<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Receive\CreateReceiveRequest;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;
use Illuminate\Http\Request;


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

    public function fetchReceiveStats(Request $request) {
        $total_receives = $this->receiveRepository->getReceiveStats($request->query('selected_year'));
        return response()->json($total_receives);
    }

    public function fetchReceiveDetails($sr_no){
        $receive = $this->receiveRepository->getReceiveDetails($sr_no);
        return response()->json($receive);
    }

    public function fetchReceivesBySearchedQuery(Request $request)
    {
        $receives = $this->receiveRepository->getReceivesBySearchedQuery($request->query('selected_year'), $request->query('query'));
        return response()->json($receives,200);
    }

    public function fetchReceivesByGroupId($receivegroup_id){
        $receive =$this->receiveRepository->getReceiveByGroupId($receivegroup_id);
        return response()->json($receive, 200);
    }

    public function fetchRecentReceiveGroups(Request $request){
        $receive_groups = $this->receiveRepository->getRecentReceiveGroups($request->query('selected_year'));
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
