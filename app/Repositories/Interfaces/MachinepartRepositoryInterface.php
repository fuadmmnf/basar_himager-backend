<?php


namespace App\Repositories\Interfaces;


interface MachinepartRepositoryInterface
{
    public function getMachineparts();

    public function saveMachinepart(array $request);

    public function saveMachinepartEntries(array $request);
}
