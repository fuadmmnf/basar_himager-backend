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

    public function fetchDeliveriesBySearchedQuery(Request $request)
    {
        $deliveries = $this->deliveryRepository->getDeliveriesBySearchedQuery($request->query('selected_year'), $request->query('query'));
        return response()->json($deliveries,200);
    }

    public function fetchDeliveriesByGroupId($deliverygroup_id){
        $receive =$this->deliveryRepository->fetchDeliveriesByGroupId($deliverygroup_id);
        return response()->json($receive, 200);
    }

    public function fetchRecentDeliverygroups(Request $request){
        $deliverygroups = $this->deliveryRepository->getRecentDeliveryGroups($request->query('selected_year'));
        return response()->json($deliverygroups,200);
    }

    public function fetchPaginatedDeliveriesByBookingID($booking_id)
    {
        $deliveries = $this->deliveryRepository->getPaginatedDeliveriesByBookingId($booking_id);

        return response()->json($deliveries, 200);
    }

    public function fetchDeliveryStats(Request $request) {
        $total_do = $this->deliveryRepository->getDeliveryStats($request->query('selected_year'));
        return response()->json($total_do);
    }

    public function createDeliverygroup(CreateDeliveryRequest $request){

        try{
            $delivery = $this->deliveryRepository->saveDeliverygroup($request->validated());
            return response()->json($delivery, 201);

        } catch (\Exception $e){
            return response()->json($e->getMessage(), 400);
        }
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
