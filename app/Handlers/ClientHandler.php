<?php


namespace App\Handlers;


use App\Models\Client;

class ClientHandler
{

    public function saveClient($info): Client {
//        $existingClient = Client::where('nid', $info['nid'])->first();
//        if($existingClient){
//            return 'existingClient';
//        }

        $newClient = new Client();
        $newClient->nid = $info['nid'];
        $newClient->name = $info['name'];
        $newClient->phone = $info['phone'];
        $newClient->father_name = $info['father_name'];
        $newClient->mother_name = $info['mother_name'];
        $newClient->address = $info['address'];;
        $newClient->year = $info['year'];;

        $newClient->client_no = sprintf('%04d', Client::whereYear('year', $newClient->year)->count() + 1) . (int)$newClient->year % 100;
        $newClient->save();

        return $newClient;
    }



}

