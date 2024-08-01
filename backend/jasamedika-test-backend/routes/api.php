<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RentalsController;
use App\Http\Controllers\ReturnCarController;

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

Route::get('cars', [CarsController::class, 'index']);
Route::get('/cars/{id}', [CarsController::class, 'show']);
Route::get('rental', [RentalsController::class, 'index']);
Route::get('/history-rental/{id}', [RentalsController::class, 'historyRent']);
Route::get('/ongoing-rental/{id}', [RentalsController::class, 'onGoingRent']);
Route::get('/rental/{id}', [RentalsController::class, 'show']);
Route::patch('/rental/{id}', [RentalsController::class, 'returnCar']);
Route::get('return-car', [ReturnCarController::class, 'index']);
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'store']);
Route::post('add-car', [CarsController::class, 'store']);
Route::post('rental', [RentalsController::class, 'store']);
Route::post('return-car', [ReturnCarController::class, 'store']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
