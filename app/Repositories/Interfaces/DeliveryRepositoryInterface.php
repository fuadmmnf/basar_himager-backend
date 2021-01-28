<?php


namespace App\Repositories\Interfaces;


interface DeliveryRepositoryInterface
{
    public function getRecentDeliveries();
    public function getRecentDeliveryGroups();
    public function fetchDeliveriesByGroupId($deliverygroup_id);
    public function saveDeliverygroup(array $request);
    public function saveGatepass(array $request);
}
