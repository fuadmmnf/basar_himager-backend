<?php


namespace App\Repositories;


use App\Handlers\ClientHandler;
use App\Models\Client;
use Intervention\Image\Facades\Image;
use PhpParser\Node\Scalar\MagicConst\File;

class ClientRepository implements Interfaces\ClientRepositoryInterface
{

    public function storeClient(array $request)
    {
        // TODO: Implement storeClient() method.
        $clientHandler = new ClientHandler();
        $client = $clientHandler
            ->saveClient($request);
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

        if ($request['photo']) {
            if($request['photo']  != $client->photo) {
                $filename = random_string(5) . time() . '.' . explode(';', explode('/', $request['photo'])[1])[0];
                $location = public_path('/images/clients/' . $filename);

                Image::make($request['photo'])->save($location);
                $client->photo = $filename;
            }

        }
        if ($request['nid_photo']) {
            if($request['nid_photo']  != $client->nid_photo) {
                $filename = random_string(5) . time() . '_nid.' . explode(';', explode('/', $request['nid_photo'])[1])[0];
                $location = public_path('/images/clients/' . $filename);

                Image::make($request['nid_photo'])->save($location);
                $client->nid_photo = $filename;
            }

        }

       $client->save();

       return $client;
    }

    public function fetchClient($year)
    {
        // TODO: Implement fetchClient() method.
        $clients = Client::where('year', $year)->paginate(15);
        return $clients;
    }

    public function fetchClientBySearchQuery($year, $query)
    {
        $clients = Client::select('clients.*')
            ->where('clients.year', $year)
            ->where(function ($q) use ($query) {
                $q->where('clients.name', 'LIKE', '%' . $query . '%')
                    ->orWhere('clients.phone', 'LIKE', $query . '%')
                    ->orWhere('clients.nid', 'LIKE', '%' . $query . '%');
            })
            ->paginate(15);
        return $clients;
    }

    public function fetchClientList($year){
        $clients = Client::where('year', $year)->get();
        return $clients;
    }

    public function fetchClientListWithFewerAttributes($year){
        $clients = Client::select('id', 'client_no','nid','name','phone')->where('year', $year)->get();
        return $clients;
    }

    public function fetchSingleClient($client_id)
    {
        $client = Client::findOrFail($client_id);
        return $client;
    }

    public function fetchSingleClientWithLoanDetail($client_id)
    {
        $client = Client::where('id',$client_id)->firstOrFail();
        $client->load('bookings','bookings.loanDisbursements');
        return $client;
        // TODO: Implement fetchSingleClientWithLoanDetail() method.
    }
}
