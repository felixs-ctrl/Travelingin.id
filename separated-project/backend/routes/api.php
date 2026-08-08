<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider or bootstrap/app.php
| within a group which is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/destinations', [ApiController::class, 'getDestinations']);
Route::get('/destinations/{id}', [ApiController::class, 'getDestination']);
Route::get('/recommendations', [ApiController::class, 'getRecommendations']);
Route::post('/bookings', [ApiController::class, 'createBooking']);
Route::get('/bookings/{id}', [ApiController::class, 'getBooking']);
Route::post('/bookings/{id}/payment', [ApiController::class, 'confirmPayment']);
