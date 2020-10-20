<?php


namespace App\Repositories\Interfaces;


interface DeliveryRepositoryInterface
{
    public function getRecentDeliveries();
    public function saveDelivery(array $request);
}
