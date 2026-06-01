<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentsController;

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

Route::middleware(['AppointmentMiddleware'])->group(function () {
    Route::get('/index_client/{userId}', [AppointmentsController::class, 'indexClient']);
    Route::post('/store_client', [AppointmentsController::class, 'storeClient']);
    Route::put('/cancel_client/{id}/{userId}', [AppointmentsController::class, 'cancelClient']);
    Route::get('/index_barber/{barberId}', [AppointmentsController::class, 'indexBarber']);
    Route::get('/index_admin', [AppointmentsController::class, 'indexAdmin']);
    Route::delete('/delete_appointment/{id}', [AppointmentsController::class, 'destroy']);
    Route::put('/confirm_barber/{barberId}/{appointmentId}', [AppointmentsController::class, 'confirmBarber']);
});
