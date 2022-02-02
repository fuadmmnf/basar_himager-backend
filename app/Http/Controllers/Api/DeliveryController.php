<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Delivery\CreateDeliveryRequest;
use App\Http\Requests\Delivery\CreateGatepassRequest;
use App\Http\Requests\Delivery\UpdateDeliveryRequest;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use Illuminate\Http\Request;

class DeliveryController extends ApiController
{
    //
    private $deliveryRepository;

    /**
     * DeliveryController constructor.
     */
    public function __construct(DeliveryRepositoryInterface $deliveryRepository)
    {
        $this->middleware('auth:api');
        $this->deliveryRepository = $deliveryRepository;
    }

    public function fetchRecentDeliveries(){
        $deliveries = $this->deliveryRepository->getRecentDeliveries();
        return response()->json($deliveries);
    }

    public function fetchDeliveriesByGroupId($deliverygroup_id){
        $receive =$this->deliveryRepository->fetchDeliveriesByGroupId($deliverygroup_id);
        return response()->json($receive, 200);
    }

    public function fetchRecentDeliverygroups(){
        $deliverygroups = $this->deliveryRepository->getRecentDeliveryGroups();
        return response()->json($deliverygroups,200);
    }

    public function fetchPaginatedDeliveriesByBookingID($booking_id)
    {
        $deliveries = $this->deliveryRepository->getPaginatedDeliveriesByBookingId($booking_id);

        return response()->json($deliveries, 200);
    }

    public function createDeliverygroup(CreateDeliveryRequest $request){

        $delivery = $this->deliveryRepository->saveDeliverygroup($request->validated());
        if(!$delivery){
            return response()->json('delivery limit exceeding bags left', 400);
        }
        return response()->json($delivery, 201);
    }

    public function uploadDeliverygroup(UpdateDeliveryRequest $request){
        $delivery = $this->deliveryRepository->updateDeliverygroup($request->validated());
        if(!$delivery){
            return response()->json('delivery limit exceeding bags left', 400);
        }
        return response()->noContent();
    }


    public function createDeliveryGatepass(CreateGatepassRequest $request){
        $gatepass = $this->deliveryRepository->saveGatepass($request->validated());
        return response()->json($gatepass, 201);
    }
}
