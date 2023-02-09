<?php

use App\Http\Controllers\AirportController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/airport', [AirportController::class, 'list']);
Route::get('/flight', [FlightController::class, 'search']);
Route::post('/booking', [BookingController::class, 'store']);
Route::get('/booking/{code}', [BookingController::class, 'info']);
Route::get('/booking/{code}/seat', [BookingController::class, 'seatInfo']);
Route::patch('/booking/{code}/seat', [BookingController::class, 'changeSeat']);

