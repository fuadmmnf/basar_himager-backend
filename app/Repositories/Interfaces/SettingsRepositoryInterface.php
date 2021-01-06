<?php


namespace App\Repositories\Interfaces;


interface SettingsRepositoryInterface
{
        public function set(array $request);
        public function get($key);
}
