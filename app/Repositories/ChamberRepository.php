<?php


namespace App\Repositories;

use App\Models\Chamber;
use App\Models\Chamberentry;
use App\Models\Inventory;
use App\Repositories\Interfaces\ChamberRepositoryInterface;
use App\Repositories\Interfaces\InventoryRepositoryInterface;
use Carbon\Carbon;

class ChamberRepository implements ChamberRepositoryInterface
{
    public function getChambers()
    {
        $chambers = Chamber::all();
        return $chambers;
    }

    public function getChamberEntriesByChamber($chamber_id)
    {
        $chamberentries = Chamberentry::where('chamber_id', $chamber_id)
            ->orderByDesc('date')->paginate(10);
        $chamberentries->load('chamber');
        return $chamberentries;
    }

    public function saveChamberStageChange(array $request)
    {
        $chamber = Chamber::findOrFail($request['chamber_id']);

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
