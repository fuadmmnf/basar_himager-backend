<?php


namespace App\Repositories;

use App\Models\Chamber;
use App\Models\Chamberentry;
use App\Models\Inventory;
use App\Repositories\Interfaces\ChamberentryRepositoryInterface;
use App\Repositories\Interfaces\ChamberRepositoryInterface;
use App\Repositories\Interfaces\InventoryRepositoryInterface;
use Carbon\Carbon;

class ChamberentryRepository implements ChamberentryRepositoryInterface
{

    public function getChamberEntriesByChamber($chamber_id)
    {
        $chamberentries = Chamberentry::where('chamber_id', $chamber_id)
            ->orderByDesc('date')->get();
//        $chamberentries->load('chamber');
        $chamber= Inventory::where('id', $chamber_id)->select('name')->firstOrFail();
        foreach ($chamberentries as $chamber_entry){
            $chamber_entry->chamber_name = $chamber;
    }
        return $chamberentries;
    }

    public function saveChamberStageChange(array $request)
    {
        $chamber = Inventory::findOrFail($request['chamber_id']);

        $newChamberentry = new Chamberentry();
        $newChamberentry->chamber_id = $chamber->id;
        $newChamberentry->stage = $request['stage'];
        $newChamberentry->date = Carbon::parse($request['date']);
        $newChamberentry->save();

        $chamber->stage = $newChamberentry->stage = $request['stage'];
        $chamber->save();

        return $newChamberentry;
    }

}
