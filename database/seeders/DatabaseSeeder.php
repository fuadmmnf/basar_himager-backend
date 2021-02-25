<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Artisan::call('migrate:fresh');
        Artisan::call('passport:client --personal --name=coldstorageapp');
        $this->call(AuthorizationSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(PotatoTypeSeeder::class);
        $this->call(ChamberSeeder::class);
    }
}
