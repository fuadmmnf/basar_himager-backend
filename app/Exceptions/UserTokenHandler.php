<?php


namespace App\Exceptions;


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


    public function regenerateUserToken($user){
//        $user->tokens()->delete();
        $user->token = $user->createToken($user->name. $user->phone)->accessToken;
        return $user;
    }


}
