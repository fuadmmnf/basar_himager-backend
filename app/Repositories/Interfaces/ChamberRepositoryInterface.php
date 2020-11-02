<?php


namespace App\Repositories\Interfaces;


interface ChamberRepositoryInterface
{
    public function getChambers();
    public function getChamberEntries();
    public function saveChamberStageChange(array $request);
}
