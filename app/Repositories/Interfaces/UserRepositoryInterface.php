<?php


namespace App\Repositories\Interfaces;


interface UserRepositoryInterface
{
    public function login(array $request);

    public function changePassword(array $request);
}
