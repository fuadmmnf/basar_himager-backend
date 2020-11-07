<?php

use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    return 'cache cleared';
});


Route::get('/report', function(){
    $pdf = PDF::loadView('template', []);
    return $pdf->stream();
});

Route::get('/download/report/loading/{receive_no}', [\App\Http\Controllers\ReportController::class, '']);

Route::get('/salary_report', [\App\Http\Controllers\Api\EmployeeSalaryController::class, 'getAllSalaries']);
Route::get('/download/report/salary/month/{month}', [\App\Http\Controllers\ReportController::class, 'downloadSalaryReport']);
Route::get('/download/report/deposit/month/{month}', [\App\Http\Controllers\ReportController::class, 'downloadBankDepositReport']);
Route::get('/download/report/expenses/month/{month}',[\App\Http\Controllers\ReportController::class,'downloadExpenseReport']);
Route::get('/download/report/receive/receipt/{id}', [\App\Http\Controllers\ReportController::class, 'getReceiveReceipt']);
Route::get('/download/report/gatepass/receipt/{delivery_id}', [\App\Http\Controllers\ReportController::class, 'getGatePass']);
Route::get('/download/report/accounting/start/{start_date}/end/{end_date}', [\App\Http\Controllers\ReportController::class, 'downloadAccountingReport']);

