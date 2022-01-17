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
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    return 'cache cleared';
});


Route::get('/migratebyadmin', function () {
        // Artisan::call('route:cache');
    try {
        Artisan::call('migrate', array('--force' => true));
        return 'Migration done';
    } catch (Exception $exception){
        return 'error';
    }
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
Route::get('/download/report/receives/receipt/{receivegroup_id}', [\App\Http\Controllers\ReportController::class, 'getReceivesReceipt']);
Route::get('/download/report/deliveries/receipt/{deliverygroup_id}', [\App\Http\Controllers\ReportController::class, 'getDeliveriesReceipt']);
Route::get('/download/report/booking/receipt/{id}', [\App\Http\Controllers\ReportController::class, 'getBookingReceipt']);
Route::get('/download/report/booking/details/{id}', [\App\Http\Controllers\ReportController::class, 'getBookingDetailsReport']);
Route::get('/download/report/loandisbursement/receipt/{id}', [\App\Http\Controllers\ReportController::class, 'getLoandisbursementReport']);
Route::get('/download/report/loancollection/receipt/{id}', [\App\Http\Controllers\ReportController::class, 'getLoancollectionReceipt']);
Route::get('/download/report/gatepass/receipt/{deliverygroup_id}', [\App\Http\Controllers\ReportController::class, 'getGatePass']);
Route::get('/download/report/accounting/start/{start_date}/end/{end_date}', [\App\Http\Controllers\ReportController::class, 'downloadAccountingReport']);
Route::get('/download/report/receives/{start_date}/end/{end_date}', [\App\Http\Controllers\ReportController::class, 'downloadReceiveReportInRange']);
Route::get('/download/report/receivegroup/loaddistributions/{receive_group_id}',[\App\Http\Controllers\ReportController::class,'getLoaddistributionReport']);
Route::get('/download/report/storepotato/{client_id}/{date}',[\App\Http\Controllers\ReportController::class,'downloadStorePotatoReceipt']);
Route::get('/download/report/dailystatement/start/{start_date}',[\App\Http\Controllers\ReportController::class,'downloadDailyStatementReport']);
