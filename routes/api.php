<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RemoteAreaController;
use App\Http\Controllers\API\ShippingCalculatorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::namespace('API')->group(function () {
    Route::post('/shipping/calculate', [ShippingCalculatorController::class, 'calculate']);
    Route::get('/remote-areas', [RemoteAreaController::class, 'index']);
});
