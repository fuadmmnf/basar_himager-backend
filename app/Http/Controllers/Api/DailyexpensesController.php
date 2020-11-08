<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Dailyexpenses\CreateDailyexpensesRequest;
use App\Repositories\Interfaces\DailyexpensesRepositoryInterface;
use Illuminate\Http\Request;

class DailyexpensesController extends ApiController
{
    //
    private $dailyexpensesRepository;

    /**
     * DailyexpensesController constructor.
     */
    public function __construct(DailyexpensesRepositoryInterface $dailyexpensesRepository)
    {
        $this->dailyexpensesRepository = $dailyexpensesRepository;
    }

    public function createDailyexpenses(CreateDailyexpensesRequest $request){

        $Dailyexpenses = $this->dailyexpensesRepository->saveDailyexpenses($request->validated());
        return response()->json($Dailyexpenses, 201);
    }

    public function fetchDailyexpenses(){
        $Dailyexpenses = $this->dailyexpensesRepository->getDailyExpenses();
        return response()->json($Dailyexpenses,200);
    }
}
