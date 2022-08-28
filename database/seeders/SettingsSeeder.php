<?php


namespace Database\Seeders;


use App\Models\settings;

class SettingsSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $keys = ['do_charge', 'fancost_per_bag'];
        foreach ($keys as $key){
            settings::create([
                'key' => $key,
                'value' => 5,
            ]);
        }
        settings::create([
            'key' => 'service_charge_rate',
            'value' => 18,
        ]);

        settings::create([
            'key' => 'current_sr_no',
            'value' => 0,
        ]);
    }
}
