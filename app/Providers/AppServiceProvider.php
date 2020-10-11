<?php

namespace App\Providers;

use App\Repositories\BookingRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\LoandisbursementRepositoryInterface;
use App\Repositories\Interfaces\LoancollectionRepositoryInterface;
use App\Repositories\LoancollectionRepository;
use App\Repositories\LoandisbursementRepository;
use App\Repositories\ReceiveRepository;
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
            BookingRepositoryInterface::class,
            ReceiveRepositoryInterface::class,
            LoandisbursementRepositoryInterface::class,
            LoancollectionRepositoryInterface::class,
        ];

        $implementations = [
            EmployeeRepository::class,
            UserRepository::class,
            BookingRepository::class,
            ReceiveRepository::class,
            LoandisbursementRepository::class,
            LoancollectionRepository::class,
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
