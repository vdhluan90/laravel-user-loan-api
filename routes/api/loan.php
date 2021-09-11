<?php

use App\Http\Controllers\LoanController;
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

Route::group([
    'prefix' => 'loans'
], function () {
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('/{id}', [LoanController::class, 'get'])->name('loans.getDetail');
        Route::post('', [LoanController::class, 'create'])->name('loans.create');
    });
});
