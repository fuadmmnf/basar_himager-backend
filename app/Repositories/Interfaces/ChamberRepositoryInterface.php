<?php


namespace App\Repositories\Interfaces;


interface ChamberRepositoryInterface
{
    public function getChambers();
    public function getChamberEntriesByChamber($chamber_id);
    public function saveChamberStageChange(array $request);
}
