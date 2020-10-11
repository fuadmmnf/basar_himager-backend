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
        $this->deliveryRepository = $deliveryRepository;
    }

    public function createDelivery(CreateDeliveryRequest $request){

        $Delivery = $this->deliveryRepository->saveDelivery($request->validated());
        return response()->json($Delivery, 201);
    }
}
