<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
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

Route::post('/registerDevice', [ApiController::class, 'registerDevice']);
Route::get('/getApps', [ApiController::class, 'getApps']);
Route::get('/getTimezones', [ApiController::class, 'getTimezones']);
Route::get('/getRegisteredDevices', [ApiController::class, 'getRegisteredDevices']);
Route::post('/newPurchase', [ApiController::class, 'newPurchase']);
Route::post('/checkSubscription', [ApiController::class, 'checkSubscription']);
Route::get('/worker', [ApiController::class, 'worker']);