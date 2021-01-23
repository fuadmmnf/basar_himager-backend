<?php


namespace App\Repositories;


use App\Models\Potatotype;

class PotatotypeRepository implements Interfaces\PotatotypeRepositoryInterface
{

    public function getPotatotypes()
    {
        // TODO: Implement getPotatotypes() method.
        $potatoTypes = Potatotype::all();
        return $potatoTypes;
    }

    public function saveNewPotatotype(array $request)
    {
        // TODO: Implement saveNewPotatotype() method.
        $potato_type = new Potatotype();

        $potato_type->type_name = $request['type_name'];

        $potato_type->save();

        return $potato_type;

    }
}
