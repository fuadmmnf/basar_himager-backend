<?php

namespace App\Providers;

use App\Repositories\BankRepository;
use App\Repositories\BookingRepository;
use App\Repositories\ChamberRepository;
use App\Repositories\DeliveryRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeeSalaryRepository;
use App\Repositories\ExpensecategoryRepository;
use App\Repositories\Interfaces\BankRepositoryInterface;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\ChamberRepositoryInterface;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\EmployeeSalaryRepositoryInterface;
use App\Repositories\Interfaces\MachinepartRepositoryInterface;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\MachinepartRepository;
use App\Repositories\ReportRepository;
use App\Repositories\Interfaces\ReceiveRepositoryInterface;
use App\Repositories\Interfaces\LoandisbursementRepositoryInterface;
use App\Repositories\Interfaces\LoancollectionRepositoryInterface;
use App\Repositories\Interfaces\ExpensecategoryRepositoryInterface;
use App\Repositories\Interfaces\DailyexpensesRepositoryInterface;
use App\Repositories\DailyexpensesRepository;
use App\Repositories\LoancollectionRepository;
use App\Repositories\LoandisbursementRepository;
use App\Repositories\ReceiveRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use function Symfony\Component\String\u;

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
            BookingRepositoryInterface::class,
            EmployeeSalaryRepositoryInterface::class,
            ReportRepositoryInterface::class,
            ReceiveRepositoryInterface::class,
            DeliveryRepositoryInterface::class,
            LoandisbursementRepositoryInterface::class,
            LoancollectionRepositoryInterface::class,
            DeliveryRepositoryInterface::class,
            ExpensecategoryRepositoryInterface::class,
            DailyexpensesRepositoryInterface::class,
            MachinepartRepositoryInterface::class,
            ChamberRepositoryInterface::class,
        ];

        $implementations = [
            EmployeeRepository::class,
            UserRepository::class,
            BankRepository::class,
            BookingRepository::class,
            EmployeeSalaryRepository::class,
            ReportRepository::class,
            ReceiveRepository::class,
            DeliveryRepository::class,
            LoandisbursementRepository::class,
            LoancollectionRepository::class,
            DeliveryRepository::class,
            ExpensecategoryRepository::class,
            DailyexpensesRepository::class,
            MachinepartRepository::class,
            ChamberRepository::class,
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
