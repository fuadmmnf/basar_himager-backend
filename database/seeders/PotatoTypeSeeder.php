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
            'Astorik',
            'Cardinal',
            'Shapla',
            'Burma',
            'Saita',
            'Kumorika',
            'Kai',
            'Diamond Seeds',
            'Astorik Seeds',
            'Cardinal Seeds',
            'Shapla Seeds',
            'Burma Seeds',
            'Saita Seeds',
            'Kumorika Seeds',
            'Kai Seeds',
        ];
        foreach ($keys as $key){
            PotatoType::create([
                'type_name' => $key
            ]);
        }
    }
}
