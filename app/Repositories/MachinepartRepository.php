<?php


namespace App\Repositories;


use App\Models\Machinepart;
use App\Models\Machinepartentry;
use App\Repositories\Interfaces\MachinepartRepositoryInterface;
use Carbon\Carbon;

class MachinepartRepository implements MachinepartRepositoryInterface
{
    public function getMachineparts()
    {
        $machineparts = Machinepart::paginate(30);
        return $machineparts;
    }

    public function saveMachinepart(array $request)
    {
        $newMachinepart = new Machinepart();
        $newMachinepart->name = $request['name'];
        $newMachinepart->save();
        return $newMachinepart;
    }

    public function saveMachinepartEntries(array $request)
    {
        $machinepart = Machinepart::findOrFail($request['machinepart_id']);
        $newMachinepartEntry = new Machinepartentry();
        $newMachinepartEntry->machinepart_id = $machinepart->id;
        $newMachinepartEntry->type = $request['type'];
        $newMachinepartEntry->quantity = $request['quantity'];
        $newMachinepartEntry->time = Carbon::parse($request['time']);
        $newMachinepartEntry->save();

        $machinepart->stock += ($newMachinepartEntry->type) ? $newMachinepartEntry->quantity : -$newMachinepartEntry->quantity;
        $machinepart->save();

        return $newMachinepartEntry;
    }

}
