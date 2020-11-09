<?php


namespace App\Repositories;


use App\Handlers\UserTokenHandler;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    private function getUserType(User $user)
    {
        if($user->hasAnyRole(['admin', 'super_admin'])){
            $user->admin;
        } elseif ($user->hasAnyRole(['manager:admin', 'manager:account', 'manager:store', 'worker'])){
            $user->employee;
        } else{
            return null;
        }
        return $user;
    }

    public function login(array $request)
    {
        $user = User::where('phone', $request['phone'])->firstOrFail();
        if($user && Hash::check($request['password'], $user->password)){
            $userTokenHandler = new UserTokenHandler();
            $user = $this->getUserType($userTokenHandler->regenerateUserToken($user));
            return $user;
        }

        return null;
    }

    public function changePassword(array $request)
    {
        $user = User::where('phone', $request['phone'])->firstOrFail();
        if(!$user || !Hash::check($request['old_password'], $user->password)){
            return null;
        }

        $user->password = Hash::make($request['password']);
        $user->save();

        $userTokenHandler = new UserTokenHandler();
        $userTokenHandler->revokeTokens($user);

        return $user;
    }


    public function fetchUserById($user_id)
    {
        // TODO: Implement fetchUserById() method.
        $user = User::findOrFail('id', $user_id);
        $user = $this->getUserType($user);
        return $user;

    }
}
