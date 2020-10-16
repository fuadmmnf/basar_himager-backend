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
Route::post('employees', [\App\Http\Controllers\Api\EmployeeController::class, 'store']);
Route::post('employees/salaries', [\App\Http\Controllers\Api\EmployeeController::class, 'storeEmployeeSalary']);


//users
Route::post('users/login', [\App\Http\Controllers\Api\UserController::class, 'authorizeUserLogin']);

//banks
Route::get('banks', [\App\Http\Controllers\Api\BankController::class, 'getAllBanks']);
Route::post('banks', [\App\Http\Controllers\Api\BankController::class, 'addBank']);
