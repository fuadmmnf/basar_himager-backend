<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends ApiController
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

    public function authorizeUserLogin(LoginRequest $request)
    {
        $user = $this->userRepository->login($request->validated());

        if ($user) {
            return response()->json($user, 200);
        } else {
            return response()->json(['message' => 'Invalild Credentials'], 401);
        }
    }


    public function changePassowrd(ChangePasswordRequest $request)
    {
        $user = $this->userRepository->changePassword($request->validated());
        if ($user) {
            return response()->json([], 400);
        } else {
            return response()->noContent();
        }
    }
}
