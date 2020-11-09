<?php


namespace App\Repositories\Interfaces;


interface BankRepositoryInterface
{
    public function createBank(array $request);
    public function getBanks();
    public function addBankDeposit(array $request);
    public function getDeposits($type);
}
