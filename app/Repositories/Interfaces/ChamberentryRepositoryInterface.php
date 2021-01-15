<?php


namespace App\Repositories\Interfaces;


interface ChamberentryRepositoryInterface
{
    public function getChamberEntriesByChamber($chamber_id);
    public function saveChamberStageChange(array $request);
}
