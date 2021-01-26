<?php


namespace App\Repositories\Interfaces;


interface PotatotypeRepositoryInterface
{
    public function getPotatotypes();
    public function saveNewPotatotype(array $request);
}
