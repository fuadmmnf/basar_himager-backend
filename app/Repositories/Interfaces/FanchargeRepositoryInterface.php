<?php


namespace App\Repositories\Interfaces;


interface FanchargeRepositoryInterface
{
    public function getFancharges();
    public function storeFancharge(array $request);
}
