<?php


namespace App\Repositories\Interfaces;


interface ReceiveRepositoryInterface
{
    public function getRecentReceives();
    public function saveReceive(array $request);
    public function getReceiveById($id);
}
