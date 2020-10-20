<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\CreateDeliveryRequest;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use Illuminate\Http\Request;

class DeliveryController extends Controller
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

    public function createDelivery(CreateDeliveryRequest $request){

        $delivery = $this->deliveryRepository->saveDelivery($request->validated());
        return response()->json($delivery, 201);
    }
}
