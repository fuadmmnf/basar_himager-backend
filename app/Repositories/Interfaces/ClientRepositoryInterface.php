<?php


namespace App\Repositories\Interfaces;


interface ClientRepositoryInterface
{
    public function storeClient(array $request);
    public function updateClient(array $request, $client_id);
    public function fetchClient();
    public function fetchClientBySearchQuery($query);
    public function fetchClientList();
    public function fetchClientListWithFewerAttributes();
    public function fetchSingleClient($client_id);
}
