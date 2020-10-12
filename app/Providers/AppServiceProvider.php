<?php

namespace App\Providers;

use App\Repositories\BookingRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\ExpensecategoryRepository;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\LoandisbursementRepositoryInterface;
use App\Repositories\Interfaces\LoancollectionRepositoryInterface;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Repositories\Interfaces\ExpensecategoryRepositoryInterface;
use App\Repositories\DeliveryRepository;
use App\Repositories\LoancollectionRepository;
use App\Repositories\LoandisbursementRepository;
use App\Repositories\ReceiveRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;use function Symfony\Component\String\u;

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
            DeliveryRepositoryInterface::class,
            ExpensecategoryRepositoryInterface::class,
        ];

        $implementations = [
            EmployeeRepository::class,
            UserRepository::class,
            BookingRepository::class,
            ReceiveRepository::class,
            LoandisbursementRepository::class,
            LoancollectionRepository::class,
            DeliveryRepository::class,
            ExpensecategoryRepository::class,
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
