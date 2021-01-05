<?php


namespace App\Repositories\Interfaces;


interface ClientRepositoryInterface
{
    public function storeClient(array $request);
    public function fetchClient();
}
