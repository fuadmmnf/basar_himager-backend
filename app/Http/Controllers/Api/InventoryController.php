<?php


namespace App\Http\Controllers\Api;

use \App\Http\Controllers\ApiController;
use App\Repositories\ChamberRepository;
use \App\Http\Requests\Inventory\CreateChamberRequest;
use App\Repositories\Interfaces\InventoryRepositoryInterface;


class InventoryController extends ApiController
{
    private $inevntoryRepository;
    /**
     * InventoryController constructor.
     */
    public function __construct(InventoryRepositoryInterface $inventoryRepository)
    {
        $this->inevntoryRepository = $inventoryRepository;
    }

    public function CreateChamber(CreateChamberRequest $request){
        $chamberRepository = new ChamberRepository();
        $chamber = $chamberRepository->saveInventory($request->validated());
        if($chamber == 'AlreadyExisting'){
            return response()->json($chamber, 203);
        }
        else return response()->json($chamber, 201);
    }

    public function fetchChamber()
    {
        $chamberRepository = new ChamberRepository();
        $chamber = $chamberRepository->getInventory();
        return response()->json($chamber, 200);
    }

}
