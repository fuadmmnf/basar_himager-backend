<?php

namespace App\Providers;

use App\Repositories\BankRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\Interfaces\BankRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $interfaces = [
            EmployeeRepositoryInterface::class,
            UserRepositoryInterface::class,
            BankRepositoryInterface::class,
        ];

        $implementations = [
            EmployeeRepository::class,
            UserRepository::class,
            BankRepository::class,
        ];

        for ($i = 0; $i < count($interfaces); $i++) {
            $this->app->bind($interfaces[$i], $implementations[$i]);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
