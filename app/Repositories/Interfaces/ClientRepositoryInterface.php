<?php


namespace App\Repositories\Interfaces;


interface ClientRepositoryInterface
{
    public function storeClient(array $request);
    public function updateClient(array $request, $client_id);
    public function fetchClient($year);
    public function fetchClientBySearchQuery($year, $query);
    public function fetchClientList($year);
    public function fetchClientListWithFewerAttributes($year);
    public function fetchSingleClient($client_id);
}
