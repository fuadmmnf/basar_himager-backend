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
        // TODO: Implement saveExpensecategory() method.
        $newExpensecategory = new Expensecategory();
        $newExpensecategory->type = $request['type'];
        $newExpensecategory->category = $request['category'];

        return $newExpensecategory;
    }
}
