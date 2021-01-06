<?php


namespace Database\Seeders;


use App\Models\settings;

class SettingsSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $keys = ['do_charge', 'fan_cost_per_bag'];
        foreach ($keys as $key){
            settings::create([
                'key' => $key,
                'value' => 5,
            ]);
        }
    }
}
