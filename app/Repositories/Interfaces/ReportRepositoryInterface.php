<?php


namespace App\Repositories\Interfaces;


interface ReportRepositoryInterface
{
    public function fetchAllSalaries($month);
    public function fetchDailyexpenses($month);
    public function getDeposits($month);
    public function getBanks();


}
