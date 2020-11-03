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

//employees
Route::get('employees/{role}', [\App\Http\Controllers\Api\EmployeeController::class, 'fetchEmployeesByRole']);
Route::get('employees', [\App\Http\Controllers\Api\EmployeeController::class, 'getAllEmployees']);
Route::get('employees/{employee_id}/loans', [\App\Http\Controllers\Api\EmployeeLoanController::class, 'getLoan']);
Route::post('employees', [\App\Http\Controllers\Api\EmployeeController::class, 'store']);
Route::post('employees/salaries', [\App\Http\Controllers\Api\EmployeeSalaryController::class, 'storeEmployeeSalary']);
Route::post('employees/loans', [\App\Http\Controllers\Api\EmployeeLoanController::class, 'store']);
Route::get('employees/{employee_id}/salaries/advances', [\App\Http\Controllers\Api\EmployeeSalaryController::class, 'getTotalAdvanceSalary']);


//users
Route::post('users/login', [\App\Http\Controllers\Api\UserController::class, 'authorizeUserLogin']);

//banks
Route::get('banks', [\App\Http\Controllers\Api\BankController::class, 'getAllBanks']);
Route::get('banks/deposits', [\App\Http\Controllers\Api\BankController::class, 'getBankDeposits']);
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
Route::post('dailyexpenses', [\App\Http\Controllers\Api\DailyexpensesController::class,'createDailyexpenses']);
Route::get('dailyexpenses', [\App\Http\Controllers\Api\DailyexpensesController::class, 'fetchDailyexpenses']);

//expensescategory
Route::post('expensecategories', [\App\Http\Controllers\Api\ExpensecategoryController::class,'createExpensecategory']);
Route::get('expensecategories', [\App\Http\Controllers\Api\ExpensecategoryController::class,'fetchExpensesCategory']);


