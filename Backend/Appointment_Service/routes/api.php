<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

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

Route::middleware(['TransactionMiddleware'])->group(function () {
    Route::get('/index_client/{userId}', [AppointmentController::class, 'indexClient']);
    Route::post('/store_client/{userId}', [AppointmentController::class, 'storeClient']);
    Route::put('/cancel_client/{id}/{userId}', [AppointmentController::class, 'cancelClient']);
    Route::get('/index_barber/{barberId}', [AppointmentController::class, 'indexBarber']);
    Route::get('/index_admin', [AppointmentController::class, 'indexAdmin']);
    Route::delete('/delete_appointment/{id}', [AppointmentController::class, 'destroy']);
});
