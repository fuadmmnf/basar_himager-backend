<?php


namespace App\Repositories\Interfaces;


interface ReceiveRepositoryInterface
{
    public function getRecentReceives();
    public function saveReceivegroup(array $request);
    public function getReceiveById($id);
}
