<?php


namespace App\Handlers;


use App\Models\Client;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

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

        $newClient->address = $info['address'];
        $newClient->year = Carbon::parse($info['year'])->year;
        $newClient->client_no = sprintf('%04d', Client::whereYear('year', $newClient->year)->count() + 1) . $newClient->year % 100;

        if ($info['photo']) {
            // $image = time(). '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ':')))[1])[0];
            $filename = random_string(5) . time() . '.' . explode(';', explode('/', $info['photo'])[1])[0];
            $location = public_path('/images/clients/' . $filename);

            Image::make($info['photo'])->save($location);
            $newClient->photo = $filename;
        }
        if ($info['nid_photo']) {
            // $image = time(). '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ':')))[1])[0];
            $filename = random_string(5) . time() . '_nid.' . explode(';', explode('/', $info['nid_photo'])[1])[0];
            $location = public_path('/images/clients/' . $filename);

            Image::make($info['nid_photo'])->save($location);
            $newClient->nid_photo = $filename;
        }

        $newClient->save();

        return $newClient;
    }



}

