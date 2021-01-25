<?php


namespace App\Repositories\Interfaces;


interface DeliveryRepositoryInterface
{
    public function getRecentDeliveries();
    public function saveDeliverygroup(array $request);
    public function saveGatepass(array $request);
}
