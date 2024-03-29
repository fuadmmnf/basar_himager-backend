<?php


namespace App\Repositories\Interfaces;


interface InventoryRepositoryInterface
{
    public function saveInventory(array $request);
    public function getInventory($inventory_type);
    public function getAllInventory();
    public function fetchInventoryByParentId($parent_id);
}
