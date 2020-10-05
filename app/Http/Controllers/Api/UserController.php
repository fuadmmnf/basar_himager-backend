<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    private $userRepository;

    /**
     * EmployeeController constructor.
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authorizeUserLogin(LoginRequest $request){
        $user = $this->userRepository->login($request->validated());

        if($user){
            return response()->json($user, 201);
        } else{
            return response()->json(['message' => 'Invalild Credentials'], 401);
        }
    }
}
