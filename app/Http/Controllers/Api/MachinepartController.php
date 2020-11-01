<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\BankTransactionRequest;
use App\Http\Requests\Bank\CreateBankRequest;
use App\Repositories\Interfaces\BankRepositoryInterface;
use App\Repositories\Interfaces\MachinepartRepositoryInterface;
use Illuminate\Http\Request;

class MachinepartController extends Controller
{
    //
    private $machinepartRepository;

    public function __construct(MachinepartRepositoryInterface $machinepartRepository)
    {
        $this->machinepartRepository = $machinepartRepository;
    }

}
