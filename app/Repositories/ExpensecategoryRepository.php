<?php


namespace App\Repositories;


use App\Handlers\UserTokenHandler;
use App\Models\Expensecategory;
use App\Repositories\Interfaces\ExpensecategoryRepositoryInterface;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class ExpensecategoryRepository implements ExpensecategoryRepositoryInterface
{
    public function saveExpensecategory(array $request)
    {
        $existingtype = Expensecategory::where('type', $request['type'])->first();
        if($existingtype && !$request['category']){
            return 'AlreadyExisting';
        }
        // TODO: Implement saveExpensecategory() method.
        $newExpensecategory = new Expensecategory();
        $newExpensecategory->type = $request['type'];
        $newExpensecategory->category = isset($request['category'])? $request['category'] : null;
        $newExpensecategory->save();

        return $newExpensecategory;
    }

    public function getExpensesCategory()
    {
        $expensecategory = Expensecategory::orderBy('type')->get();
        return $expensecategory;
        // TODO: Implement getExpensesCategory() method.
    }
}
