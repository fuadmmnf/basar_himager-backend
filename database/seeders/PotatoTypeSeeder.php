<?php


namespace Database\Seeders;


use App\Models\Potatotype;
use Illuminate\Database\Seeder;

class PotatoTypeSeeder extends Seeder
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
            PotatoType::create([
                'type_name' => $key
            ]);
        }
    }
}
