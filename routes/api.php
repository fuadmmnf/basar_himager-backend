<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//users
Route::post('users/login', [\App\Http\Controllers\Api\UserController::class, 'authorizeUserLogin']);
Route::get('users/{user_id}',[\App\Http\Controllers\Api\UserController::class, 'getUserbyId']);
Route::put('users/password', [\App\Http\Controllers\Api\UserController::class, 'changePassowrd']);

//employees
Route::get('employees/{role}', [\App\Http\Controllers\Api\EmployeeController::class, 'fetchEmployeesByRole']);
Route::get('employees', [\App\Http\Controllers\Api\EmployeeController::class, 'getAllEmployees']);
Route::get('employees/{employee_id}/loans', [\App\Http\Controllers\Api\EmployeeLoanController::class, 'getLoan']);
Route::get('employees/salaries/{employee_id}',[\App\Http\Controllers\Api\EmployeeSalaryController::class,'getSalaryByEmployeeId']);
Route::post('employees', [\App\Http\Controllers\Api\EmployeeController::class, 'store']);
Route::post('employees/salaries', [\App\Http\Controllers\Api\EmployeeSalaryController::class, 'storeEmployeeSalary']);
Route::post('employees/loans', [\App\Http\Controllers\Api\EmployeeLoanController::class, 'store']);



//banks
Route::get('banks', [\App\Http\Controllers\Api\BankController::class, 'getAllBanks']);
Route::get('banks/deposits/type/{type}', [\App\Http\Controllers\Api\BankController::class, 'fetchBankDepositsByType']);
Route::post('banks', [\App\Http\Controllers\Api\BankController::class, 'addBank']);
Route::post('banks/deposits', [\App\Http\Controllers\Api\BankController::class, 'storeBankDeposit']);

//bookings
Route::get('bookings/{booking_id}/receives', [\App\Http\Controllers\Api\BookingController::class, 'fetchPaginatedReceivesByBookingID']);
Route::get('bookings/{booking_id}/deliveries', [\App\Http\Controllers\Api\BookingController::class, 'fetchPaginatedDeliveriesByBookingID']);
Route::get('bookings/{booking_id}/loandisbursements', [\App\Http\Controllers\Api\BookingController::class, 'fetchPaginatedLoanDisbursementByBookingID']);
Route::get('bookings/{booking_id}/loancollections', [\App\Http\Controllers\Api\BookingController::class, 'fetchPaginatedLoanCollectionByBookingID']);
Route::get('booking/search?query={query}', [\App\Http\Controllers\Api\BookingController::class, 'bookingListBySearchedQuery']);
Route::get('bookings/{booking_no}', [\App\Http\Controllers\Api\BookingController::class, 'fetchBookingDetail']);
Route::get('bookings', [\App\Http\Controllers\Api\BookingController::class, 'fetchBookings']);
Route::post('bookings', [\App\Http\Controllers\Api\BookingController::class, 'createBooking']);

//receives
Route::get('receives', [\App\Http\Controllers\Api\ReceiveController::class, 'fetchRecentReceives']);
Route::get('receives/{id}',[\App\Http\Controllers\Api\ReceiveController::class, 'fetchReceivesById']);
Route::post('receives', [\App\Http\Controllers\Api\ReceiveController::class, 'createReceive']);

//deliveries
Route::get('deliveries', [\App\Http\Controllers\Api\DeliveryController::class, 'fetchRecentDeliveries']);
Route::post('deliveries', [\App\Http\Controllers\Api\DeliveryController::class, 'createDelivery']);
//Delivery Gatepasses
Route::post('gatepasses', [\App\Http\Controllers\Api\DeliveryController::class, 'createDeliveryGatepass']);


//loanDisbursements
Route::get('loandisbursements', [\App\Http\Controllers\Api\LoandisbursementController::class, 'fetchLoandisbursements']);
Route::post('loandisbursements', [\App\Http\Controllers\Api\LoandisbursementController::class, 'createLoan']);

//loancollections
Route::post('loancollections', [\App\Http\Controllers\Api\LoancollectionController::class, 'createLoancollection']);

//delivery
Route::post('delivery', [\App\Http\Controllers\Api\DeliveryController::class, 'createDelivery']);

//dailyexpenses
Route::post('dailyexpenses', [\App\Http\Controllers\Api\DailyexpensesController::class, 'createDailyexpenses']);
Route::get('dailyexpenses', [\App\Http\Controllers\Api\DailyexpensesController::class, 'fetchDailyexpenses']);

//expensescategories
Route::post('expensecategories', [\App\Http\Controllers\Api\ExpensecategoryController::class, 'createExpensecategory']);
Route::get('expensecategories', [\App\Http\Controllers\Api\ExpensecategoryController::class, 'fetchExpensesCategory']);


//machineparts
Route::get('machineparts', [\App\Http\Controllers\Api\MachinepartController::class, 'fetchMachineparts']);
Route::get('machinepartentries', [\App\Http\Controllers\Api\MachinepartController::class, 'fetchMachinepartEntries']);
Route::post('machineparts', [\App\Http\Controllers\Api\MachinepartController::class, 'createMachinepart']);
Route::post('machinepartentries', [\App\Http\Controllers\Api\MachinepartController::class, 'createMachinepartEntries']);


//chambers
Route::get('chambers', [\App\Http\Controllers\Api\ChamberController::class, 'fetchChambers']);

//chamberentries
Route::get('chambers/{chamber_id}/chamberentries', [\App\Http\Controllers\Api\ChamberentryController::class, 'fetchChamberentriesByChamber']);
Route::post('chamberentries', [\App\Http\Controllers\Api\ChamberentryController::class, 'createChamberentry']);


//====>Inventory
Route::get('inventories/{inventory_type}', [\App\Http\Controllers\Api\InventoryController::class, 'fetchInventory']);
Route::get('inventories/{parent_id}/parents', [\App\Http\Controllers\Api\InventoryController::class, 'getInventoryWithParentId']);
Route::post('inventories', [\App\Http\Controllers\Api\InventoryController::class, 'createInventory']);
//====>load
Route::post('loaddistributions', [\App\Http\Controllers\Api\LoaddistributionController::class, 'createLoadDistribution']);
Route::get('clients/{client_id}/loaddistributions/dates',[\App\Http\Controllers\Api\LoaddistributionController::class,'getloaddistributionDatesByClient']);
Route::get('loaddistributions/{receive_id}',[\App\Http\Controllers\Api\LoaddistributionController::class,'getloaddistributionByReceive']);
Route::get('loaddistributions/booking/{booking_id}',[\App\Http\Controllers\Api\LoaddistributionController::class,'fetchLoaddistributionByBooking']);

//unloading
Route::post('unloadings', [\App\Http\Controllers\Api\UnloadingController::class,'saveUnloading']);
//client
Route::post('clients', [\App\Http\Controllers\Api\ClientController::class, 'createClient']);
Route::get('clients', [\App\Http\Controllers\Api\ClientController::class, 'getClients']);
Route::get('clients/list', [\App\Http\Controllers\Api\ClientController::class,'getClientList']);
Route::get('clients/list/customized', [\App\Http\Controllers\Api\ClientController::class,'getClientsWithFewerAttributes']);

//settings
Route::get('settings', [\App\Http\Controllers\Api\SettingsController::class,'fetch']);
Route::post('settings',[\App\Http\Controllers\Api\SettingsController::class, 'updateSettings']);

//Potatotype
Route::get('potatotypes',[\App\Http\Controllers\Api\PotatotypeController::class, 'fetchPotatotypes']);
Route::post('potatotypes',[\App\Http\Controllers\Api\PotatotypeController::class, 'saveNewPotatotype']);
