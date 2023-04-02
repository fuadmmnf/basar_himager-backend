<?php

namespace Database\Seeders;
use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientIDScriptSeeder extends Seeder
{
    public function run()
    {
        $all_clients = Client::get()->groupBy('year');
        foreach ($all_clients as $client_group) {
            foreach ($client_group as $key => $client) {
                $client->client_no = sprintf('%04d', $key+1). '_' . $client->year % 100;
                $client->save();
            }
        }
    }
}
