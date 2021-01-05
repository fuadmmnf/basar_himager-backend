<?php


namespace App\Repositories;


use App\Handlers\ClientHandler;
use App\Models\Client;

class ClientRepository implements Interfaces\ClientRepositoryInterface
{

    public function storeClient(array $request)
    {
        // TODO: Implement storeClient() method.
        $clientHandler = new ClientHandler();
        $client = $clientHandler
            ->saveClient($request['nid'], $request['name'],
                $request['phone'], $request['father_name'], $request['mother_name'],$request['address']);
        return $client;
    }

    public function fetchClient()
    {
        // TODO: Implement fetchClient() method.
        $clients = Client::paginate(15);
        return $clients;
    }
}
