<?php

namespace App\Repositories;

use App\Models\Loaddistribution;
use App\Repositories\Interfaces\LoaddistributionRepositoryInterface;


class LoaddistributionRepository implements LoaddistributionRepositoryInterface
{


    public function saveLoaddistrbution(array $request)
    {
        // TODO: Implement saveLoaddistrbution() method.

        DB::beginTransaction();
        try{
            $newLoaddistribution=new Loaddistribution();
            $newLoaddistribution->receiving_no = $request['receiving_no'];
            $newLoaddistribution->compartment_id = $request['compartment_id'];

            foreach ($request['distributions'] as $distribution){
                $newLoaddistribution->potato_type = $distribution['potato_type'];
                $newLoaddistribution->quantity = $distribution['quantity'];
                $newLoaddistribution->save();
            }
        }catch (\Exception $e){
            DB::rollback();
        }
        DB::commit();

        return $newLoaddistribution;
    }
}
