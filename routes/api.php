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
Route::get('bookings/{booking_id}/receives', [\App\Http\Controllers\Api\BookingController::class, 'fetchPaginatedReceivesByBookingID']);
Route::get('bookings/{booking_id}/deliveries', [\App\Http\Controllers\Api\BookingController::class, 'fetchPaginatedDeliveriesByBookingID']);
Route::get('bookings/{booking_id}/loandisbursements', [\App\Http\Controllers\Api\BookingController::class, 'fetchPaginatedLoanDisbursementByBookingID']);
Route::get('bookings/{booking_id}/loancollections', [\App\Http\Controllers\Api\BookingController::class, 'fetchPaginatedLoanCollectionByBookingID']);
