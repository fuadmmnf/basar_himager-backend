<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Requests\Settings\Potatotype\CreatePotatotypeRequest;
use App\Repositories\Interfaces\PotatotypeRepositoryInterface;

class PotatotypeController extends ApiController
{
    private $potatotypeRepository;

    public function __construct(PotatotypeRepositoryInterface $potatotypeRepository)
    {
        $this->potatotypeRepository = $potatotypeRepository;
    }

    public function fetchPotatotypes(){
        $potatotypes = $this->potatotypeRepository->getPotatotypes();
        return response()->json($potatotypes, 200);
    }

    public function saveNewPotatotype(CreatePotatotypeRequest $request){
        $potatotypes = $this->potatotypeRepository->saveNewPotatotype($request->validated());
        return response()->json($potatotypes, 201);
    }

}
