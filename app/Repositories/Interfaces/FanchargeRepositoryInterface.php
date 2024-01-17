<?php


namespace App\Repositories\Interfaces;


interface FanchargeRepositoryInterface
{
    public function getFancharges($year);
    public function getFanchargesBySearchQuery($query);
    public function storeFancharge(array $request);
}
