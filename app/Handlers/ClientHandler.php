<?php


namespace App\Handlers;


use App\Models\Client;

class ClientHandler
{
    public function saveClient($nid, $name, $father_name, $address): Client {
        $existingClient = Client::where('nid', $nid)->first();
        if($existingClient){
            return $existingClient;
        }

        $newClient = new Client();
        $newClient->nid = $nid;
        $newClient->name = $name;
        $newClient->father_name = $father_name;
        $newClient->address = json_encode($address);

            $newClient->save();

        return $newClient;
    }


//    public function regenerateClientToken($Client){
////        $Client->tokens()->delete();
//        $Client->token = $Client->createToken($Client->name. $Client->phone)->accessToken;
//        return $Client;
//    }


}

