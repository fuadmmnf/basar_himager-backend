<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Dailyexpense;
use App\Models\Delivery;
use App\Models\Employeeloan;
use App\Models\Employeesalary;
use App\Models\Fancharge;
use App\Models\Loancollection;
use App\Models\Loandisbursement;
use App\Observers\BookingObserver;
use App\Observers\DailyexpenseObserver;
use App\Observers\DeliveryObserver;
use App\Observers\EmployeeloanObserver;
use App\Observers\EmployeesalaryObserver;
use App\Observers\FanchargeObserver;
use App\Observers\LoancollectionObserver;
use App\Observers\LoandisbursementObserver;
use App\Repositories\BankRepository;
use App\Repositories\BookingRepository;
use App\Repositories\ChamberentryRepository;
use App\Repositories\ChamberRepository;
use App\Repositories\ClientRepository;
use App\Repositories\DeliveryRepository;
use App\Repositories\EmployeeLoanRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EmployeeSalaryRepository;
use App\Repositories\ExpensecategoryRepository;
use App\Repositories\FanchargeRepository;
use App\Repositories\FloorRepository;
use App\Repositories\Interfaces\BankRepositoryInterface;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\ChamberentryRepositoryInterface;
use App\Repositories\Interfaces\ChamberRepositoryInterface;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Repositories\Interfaces\EmployeeLoanRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\EmployeeSalaryRepositoryInterface;
use App\Repositories\Interfaces\FanchargeRepositoryInterface;
use App\Repositories\Interfaces\LoaddistributionRepositoryInterface;
use App\Repositories\Interfaces\MachinepartRepositoryInterface;
use App\Repositories\Interfaces\PotatotypeRepositoryInterface;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Repositories\Interfaces\SettingsRepositoryInterface;
use App\Repositories\Interfaces\UnloadingRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\InventoryRepository;
use App\Repositories\LineRepository;
use App\Repositories\LoaddistributionRepository;
use App\Repositories\MachinepartRepository;
use App\Repositories\PocketRepository;
use App\Repositories\PositionRepository;
use App\Repositories\PotatotypeRepository;
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
use App\Repositories\SettingsRepositopry;
use App\Repositories\UnloadingRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use function Symfony\Component\String\u;
use \App\Repositories\Interfaces\InventoryRepositoryInterface;

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
            EmployeeLoanRepositoryInterface::class,
            MachinepartRepositoryInterface::class,
            ChamberRepositoryInterface::class,
            ChamberentryRepositoryInterface::class,
            InventoryRepositoryInterface::class,
            LoaddistributionRepositoryInterface::class,
            UnloadingRepositoryInterface::class,
            ClientRepositoryInterface::class,
            SettingsRepositoryInterface::class,
            PotatotypeRepositoryInterface::class,
            FanchargeRepositoryInterface::class,
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
            EmployeeLoanRepository::class,
            MachinepartRepository::class,
            ChamberRepository::class,
            ChamberentryRepository::class,
            InventoryRepository::class,
            LoaddistributionRepository::class,
            UnloadingRepository::class,
            ClientRepository::class,
            SettingsRepositopry::class,
            PotatotypeRepository::class,
            FanchargeRepository::class,
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
        Booking::observe(BookingObserver::class);
        Dailyexpense::observe(DailyexpenseObserver::class);
        Delivery::observe(DeliveryObserver::class);
        Employeeloan::observe(EmployeeloanObserver::class);
        Employeesalary::observe(EmployeesalaryObserver::class);
        Loandisbursement::observe(LoandisbursementObserver::class);
        Loancollection::observe(LoancollectionObserver::class);
        Fancharge::observe(FanchargeObserver::class);
    }
}
