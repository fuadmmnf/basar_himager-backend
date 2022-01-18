<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\Request;

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

    public function getClients(Request $request){
        $clients = $this->clientRepository->fetchClient($request->query('selected_year'),);
        return response()->json($clients,200);
    }

    public function getClientsBySearchQuery(Request $request){
        $clients = $this->clientRepository->fetchClientBySearchQuery($request->query('selected_year'), $request->query('query'));
        return response()->json($clients,200);
    }

    public function getClientsWithFewerAttributes(Request $request){
        $clients = $this->clientRepository->fetchClientListWithFewerAttributes($request->query('selected_year'));
        return response()->json($clients,200);
    }

    public function getSingleClient($client_id) {
        $client = $this->clientRepository->fetchSingleClient($client_id);
        return response()->json($client,200);
    }
    public function getClientList(Request $request){
        $clients = $this->clientRepository->fetchClientList($request->query('selected_year'));
        return response()->json($clients,200);
    }

    public function getSingleClientWithLoanDetail($client_id){
        $client = $this->clientRepository->fetchSingleClientWithLoanDetail($client_id);
        return response()->json($client,200);
    }
}
