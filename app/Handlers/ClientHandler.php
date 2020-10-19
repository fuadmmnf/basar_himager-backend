<?php


namespace App\Handlers;


use App\Models\Client;

class ClientHandler
{
    public function saveClient($nid, $name, $phone, $father_name, $address): Client {
        $existingClient = Client::where('nid', $nid)->first();
        if($existingClient){
            return $existingClient;
        }

        $newClient = new Client();
        $newClient->nid = $nid;
        $newClient->name = $name;
        $newClient->phone = $phone;
        $newClient->father_name = $father_name;
        $newClient->address = $address;
        $newClient->save();

        return $newClient;
    }


//    public function regenerateClientToken($Client){
////        $Client->tokens()->delete();
//        $Client->token = $Client->createToken($Client->name. $Client->phone)->accessToken;
//        return $Client;
//    }


}

