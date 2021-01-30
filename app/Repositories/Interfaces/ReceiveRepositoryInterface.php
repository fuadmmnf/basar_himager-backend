<?php


namespace App\Repositories\Interfaces;


interface ReceiveRepositoryInterface
{
    public function getRecentReceives();
    public function getRecentReceiveGroups();
    public function saveReceivegroup(array $request);
    public function getReceiveByGroupId($id);
}
