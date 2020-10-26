<?php


namespace App\Repositories\Interfaces;


interface ReportRepositoryInterface
{
    public function fetchAllSalaries($month);
    public function getDeposits($month);

}
