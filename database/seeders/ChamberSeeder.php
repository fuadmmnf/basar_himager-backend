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
        for ($i=1; $i<=1; $i++) {
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
                for ($k = 1; $k<=102; $k++) {
                    $compartment = Inventory::create([
                        'parent_id' => $floor->id,
                        'category' => 'compartment',
                        'name' => $k,
                    ]);
                }
            }
        }



        for ($i=2; $i<=2; $i++) {
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
                for ($k = 1; $k<=136; $k++) {
                    $compartment = Inventory::create([
                        'parent_id' => $floor->id,
                        'category' => 'compartment',
                        'name' => $k,
                    ]);
                }
            }
        }


        for ($i=3; $i<=3; $i++) {
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
                for ($k = 1; $k<= ($j>2? 128: 112); $k++) {
                    $compartment = Inventory::create([
                        'parent_id' => $floor->id,
                        'category' => 'compartment',
                        'name' => $k,
                    ]);
                }
            }
        }
    }

}
