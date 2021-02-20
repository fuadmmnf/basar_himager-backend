<?php

namespace Database\Seeders;

use App\Models\Chamber;
use App\Models\Inventory;
use Illuminate\Database\Seeder;

class ChamberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<=5; $i++) {
            $chamber =  Inventory::create([
                'category' => 'chamber',
                'name' => $i,
                'stage' => 'Stage-0'
            ]);
            for ($j = 1; $j<=5; $j++) {
                $floor = Inventory::create([
                    'parent_id' => $chamber->id,
                    'category' => 'floor',
                    'name' => $j,
                ]);
                for ($k = 1; $k<=5; $k++) {
                    $floor = Inventory::create([
                        'parent_id' => $floor->id,
                        'category' => 'compartment',
                        'name' => $k,
                    ]);
                }
            }
        }
    }
}
