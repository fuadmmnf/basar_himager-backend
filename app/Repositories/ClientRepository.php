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

    public function updateClient(array $request, $client_id)
    {
        // TODO: Implement storeClient() method.
       $client = Client::find($client_id);

       $client->nid = $request['nid'];
       $client->name = $request['name'];
       $client->phone = $request['phone'];
       $client->father_name = $request['father_name'];
       $client->mother_name = $request['mother_name'];
       $client->address = $request['address'];
       $client->save();

       return $client;
    }

    public function fetchClient()
    {
        // TODO: Implement fetchClient() method.
        $clients = Client::paginate(15);
        return $clients;
    }

    public function fetchClientBySearchQuery($query)
    {
        $clients = Client::select('clients.*')
            ->where('clients.name', 'LIKE', '%' . $query . '%')
            ->orWhere('clients.phone', 'LIKE', '%' . $query . '%')
            ->orWhere('clients.nid', 'LIKE', '%' . $query . '%')
            ->paginate(15);
        return $clients;
    }

    public function fetchClientList(){
        $clients = Client::all();
        return $clients;
    }

    public function fetchClientListWithFewerAttributes(){
        $clients = Client::select('id', 'client_no','nid','name','phone')->get();
        return $clients;
    }

    public function fetchSingleClient($client_id)
    {
        $client = Client::findOrFail($client_id);
        return $client;
    }
}
