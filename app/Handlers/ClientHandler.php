<?php


namespace App\Handlers;


use App\Models\Client;

class ClientHandler
{

    public function saveClient($nid, $name, $phone, $father_name, $mother_name ,$address): Client {
        $existingClient = Client::where('nid', $nid)->first();
        if($existingClient){
            return 'existingClient';
        }

        $newClient = new Client();
        $newClient->nid = $nid;
        $newClient->name = $name;
        $newClient->phone = $phone;
        $newClient->father_name = $father_name;
        $newClient->mother_name = $mother_name;
        $newClient->address = $address;
        $newClient->save();

        $newClient->client_no = sprintf('%04d',$newClient->id);
        $newClient->save();

        return $newClient;
    }



}

