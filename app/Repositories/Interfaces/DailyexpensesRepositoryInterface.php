<?php

namespace App\Repositories\Interfaces;


interface DailyexpensesRepositoryInterface
{
    public function saveDailyexpenses(array $request);
    public function getDailyExpenses();
}
