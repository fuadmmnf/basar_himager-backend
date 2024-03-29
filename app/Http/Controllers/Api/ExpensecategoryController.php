<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Expensecategory\CreateExpensecategoryRequest;
use App\Repositories\Interfaces\ExpensecategoryRepositoryInterface;
use Illuminate\Http\Request;

class ExpensecategoryController extends ApiController
{
    //
    private $expensecategoryRepository;

    /**
     * ExpensecategoryController constructor.
     */
    public function __construct(ExpensecategoryRepositoryInterface $expensecategoryRepository)
    {
        $this->expensecategoryRepository = $expensecategoryRepository;
    }

    public function createExpensecategory(CreateExpensecategoryRequest $request){

        $Expensecategory = $this->expensecategoryRepository->saveExpensecategory($request->validated());
        if($Expensecategory == 'AlreadyExisting'){
            return response()->json($Expensecategory, 203);
        }
        else return response()->json($Expensecategory, 201);
    }

    public function fetchExpensesCategory()
    {
        $Expensecategory = $this->expensecategoryRepository->getExpensesCategory();

        return response()->json($Expensecategory, 200);
    }


}
