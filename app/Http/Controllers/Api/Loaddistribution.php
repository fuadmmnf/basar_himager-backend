<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Repositories\Interfaces\LoaddistributionRepositoryInterface;


class Loaddistribution extends ApiController
{

    private $loaddistributionRepository;

    /**
     * LoancollectionController constructor.
     */
    public function __construct(LoaddistributionRepositoryInterface $loaddistributionRepository)
    {
        $this->loaddistributionRepository = $loaddistributionRepository;
    }

}

