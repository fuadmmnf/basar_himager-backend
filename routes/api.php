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
Route::post('employees', [\App\Http\Controllers\Api\EmployeeController::class, 'store']);


//users
Route::post('users/login', [\App\Http\Controllers\Api\UserController::class, 'authorizeUserLogin']);

//bookings
Route::post('bookings', [\App\Http\Controllers\Api\BookingController::class,'createBooking']);

//receive
Route::post('receives', [\App\Http\Controllers\Api\ReceiveController::class,'createReceive']);

//loanDisbursement
Route::post('loandisbursements', [\App\Http\Controllers\Api\LoandisbursementController::class,'createLoan']);

//loancollection
Route::post('loancollections', [\App\Http\Controllers\Api\LoancollectionController::class, 'createLoancollection']);

//delivery
Route::post('delivery', [\App\Http\Controllers\Api\DeliveryController::class, 'createDelivery']);

//dailyexpenses
Route::post('dailyexpenses', [\App\Http\Controllers\Api\DailyexpensesController::class,'createDailyexpenses']);
Route::get('dailyexpenses', [\App\Http\Controllers\Api\DailyexpensesController::class, 'fetchDailyexpenses']);

//expensescategory
Route::post('expensecategories', [\App\Http\Controllers\Api\ExpensecategoryController::class,'createExpensecategory']);
Route::get('expensecategories', [\App\Http\Controllers\Api\ExpensecategoryController::class,'fetchExpensesCategory']);


