<?php


namespace App\Repositories\Interfaces;


interface ClientRepositoryInterface
{
    public function storeClient(array $request);
    public function updateClient(array $request, $client_id);
    public function fetchClient();
    public function fetchClientList();
    public function fetchClientListWithFewerAttributes();
}
