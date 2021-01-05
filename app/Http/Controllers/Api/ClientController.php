<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\Client\CreateClientRequest;
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

    public function getClients(){
        $clients = $this->clientRepository->fetchClient();
        return response()->json($clients,200);
    }

    public function getClientList(){
        $clients = $this->clientRepository->fetchClientList();
        return response()->json($clients,200);
    }
}
