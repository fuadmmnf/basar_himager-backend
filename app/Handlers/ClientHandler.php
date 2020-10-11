<?php


namespace App\Handlers;


use App\Models\Client;

class ClientHandler
{
    public function saveClient($nid, $name, $father_name, $address): Client {
        $newClient = new Client();

        $user = Client::where('nid', $nid)->first();

        $newClient->nid = $nid;
        $newClient->name = $name;
        $newClient->father_name = $father_name;
        $newClient->address = json_encode($address);

        if(!$user){
            $newClient->save();
        }
        else{
            $newClient=$user;
        }

        return $newClient;
    }


//    public function regenerateClientToken($Client){
////        $Client->tokens()->delete();
//        $Client->token = $Client->createToken($Client->name. $Client->phone)->accessToken;
//        return $Client;
//    }


}

