<?php

namespace Database\Seeders;

use App\Models\Chamber;
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
        $chambers = ['chamber-1', 'chamber-2', 'chamber-3'];
        foreach ($chambers as $chamber){
            Chamber::create([
                'name' => $chamber
            ]);
        }
    }
}
