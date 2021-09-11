<?php

use App\Http\Controllers\TransactionController;
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
    'prefix' => 'transactions'
], function () {
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::post('', [TransactionController::class, 'create'])->name('transactions.create');
    });
});
