<?php


namespace App\Http\Controllers\Api;

use \App\Http\Controllers\ApiController;
use App\Http\Requests\Inventory\CreateInventoryRequest;
use App\Repositories\ChamberRepository;
use App\Repositories\Interfaces\InventoryRepositoryInterface;


class InventoryController extends ApiController
{
    private $inventoryRepository;
    /**
     * InventoryController constructor.
     */
    public function __construct(InventoryRepositoryInterface $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function createInventory(CreateInventoryRequest $request){
        $inventory = $this->inventoryRepository->saveInventory($request->validated());
        if($inventory == 'AlreadyExisting' || $inventory=='NotEnoughCapacity'){
            return response()->json($inventory, 203);
        }
        else return response()->json($inventory, 201);
    }

    public function fetchInventory($inventory_type)
    {
        $inventory = $this->inventoryRepository->getInventory($inventory_type);
        return response()->json($inventory, 200);
    }
    public function fetchAllInventory()
    {

        $inventory = $this->inventoryRepository->getAllInventory();
        return response()->json($inventory, 200);
    }

    public function getInventoryWithParentId($parent_id){
        $inventory = $this->inventoryRepository->fetchInventoryByParentId($parent_id);
        return response()->json($inventory, 200);
    }

}
