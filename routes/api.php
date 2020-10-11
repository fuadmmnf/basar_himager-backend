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
Route::get('bookings/{booking_no}', [\App\Http\Controllers\Api\BookingController::class, 'fetchBookingDetail']);
Route::get('bookings', [\App\Http\Controllers\Api\BookingController::class, 'fetchBookings']);
Route::post('bookings', [\App\Http\Controllers\Api\BookingController::class, 'createBooking']);

//receives
Route::post('receives', [\App\Http\Controllers\Api\ReceiveController::class, 'createReceive']);

//loanDisbursements
Route::post('loandisbursements', [\App\Http\Controllers\Api\LoandisbursementController::class, 'createLoan']);

//loancollections
Route::post('loancollections', [\App\Http\Controllers\Api\LoancollectionController::class, 'createLoancollection']);
