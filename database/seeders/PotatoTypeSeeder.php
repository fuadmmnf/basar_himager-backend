<?php


namespace Database\Seeders;


use App\Models\Potatotype;

class PotatoTypeSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $keys = [
            'Diamond',
            'Cardinal',
            'Shapla',
            'Burma',
            'Saita',
            'Diamond Seeds',
            'Cardinal Seeds',
            'Shapla Seeds',
            'Burma Seeds',
            'Saita Seeds',
        ];
        foreach ($keys as $key){
            PotatoTypeSeeder::create([
                'type_name' => $key,
            ]);
        }
    }
}
