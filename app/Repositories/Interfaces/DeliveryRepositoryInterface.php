<?php


namespace App\Repositories\Interfaces;


interface DeliveryRepositoryInterface
{
    public function getRecentDeliveries();
    public function getRecentDeliveryGroups($year);
    public function fetchDeliveriesByGroupId($deliverygroup_id);
    public function getPaginatedDeliveriesByBookingId($booking_id);
    public function saveDeliverygroup(array $request);
    public function updateDeliverygroup(array $request);
    public function saveGatepass(array $request);
}
