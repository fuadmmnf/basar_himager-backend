<?php


namespace App\Repositories\Interfaces;


interface ExpensecategoryRepositoryInterface
{
    public function saveExpensecategory(array $request);
    public function getExpensesCategory();
}
