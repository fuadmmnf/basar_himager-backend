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
}
