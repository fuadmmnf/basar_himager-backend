<?php


namespace App\Handlers;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTokenHandler
{
    public function createUser($nid, $name, $phone, $password): User {
        $newUser = new User();
        $newUser->nid = $nid;
        $newUser->name = $name;
        $newUser->phone = $phone;
        $newUser->password = Hash::make($password);
        $newUser->save();
        $newUser->token = $newUser->createToken($newUser->name. $newUser->phone)->accessToken;
        return $newUser;
    }

    public function updateUser($userId, $nid, $name, $phone): User
    {
        $user = User::findOrFail($userId);

        // Update user details
        $user->nid = $nid;
        $user->name = $name;
        $user->phone = $phone;

        // Save the updated user details
        $user->save();


        return $user;
    }



    public function regenerateUserToken(User $user){
//        $user->tokens()->delete();
        $user->token = $user->createToken($user->name. $user->phone)->accessToken;
        return $user;
    }

    public function revokeTokens(User $user){
        $user->tokens()->delete();
    }
}
