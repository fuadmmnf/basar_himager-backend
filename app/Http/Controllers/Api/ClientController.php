<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Repositories\Interfaces\ClientRepositoryInterface;

class ClientController extends \App\Http\Controllers\ApiController
{
    private $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository){
        $this->clientRepository = $clientRepository;
    }

    public function createClient(CreateClientRequest $request){
        $client = $this->clientRepository->storeClient($request->validated());
        return response()->json($client, 201);
    }
    public function updateClient(UpdateClientRequest $request, $client_id){
        $client = $this->clientRepository->updateClient($request->validated(), $client_id);
        return response()->json($client, 201);
    }

    public function getClients(){
        $clients = $this->clientRepository->fetchClient();
        return response()->json($clients,200);
    }

    public function getClientsBySearchQuery($query){
        $clients = $this->clientRepository->fetchClientBySearchQuery($query);
        return response()->json($clients,200);
    }

    public function getClientsWithFewerAttributes(){
        $clients = $this->clientRepository->fetchClientListWithFewerAttributes();
        return response()->json($clients,200);
    }

    public function getSingleClient($client_id) {
        $client = $this->clientRepository->fetchSingleClient($client_id);
        return response()->json($client,200);
    }
    public function getClientList(){
        $clients = $this->clientRepository->fetchClientList();
        return response()->json($clients,200);
    }
}
