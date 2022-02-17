<?php

use Illuminate\Http\Request;
use Modules\Orders\Http\Controllers\Api\TripController;

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

Route::middleware('auth:api')->prefix('trips')->group(function () {
    Route::get('/', [TripController::class, 'index']);
    Route::post('/', [TripController::class, 'store']);
});
