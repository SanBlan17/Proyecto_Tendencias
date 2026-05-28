<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BarberController;

/*
|--------------------------------------------------------------------------
| API Routes - Gateway
|--------------------------------------------------------------------------
|
| Este es el punto de entrada centralizado para todos los microservicios.
| Aquí se manejan las peticiones del frontend y se enrutan a los servicios correspondientes.
| Autenticación: JWT (PHPOpenSourceSaver/JWTAuth)
|
*/



Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');



Route::middleware('auth:api', 'role:ADMIN')->group(function () {
    Route::get('/appointments_index_admin', [AppointmentController::class, 'index_admin']);
    Route::delete('/appointments_destroy/{id}', [AppointmentController::class, 'destroy']);

});

Route::middleware('auth:api', 'role:BARBERO')->group(function () {
    Route::get('/appointments_index_barbero', [AppointmentController::class, 'index_barber']);
});

Route::middleware('auth:api', 'role:CLIENTE')->group(function () {
    Route::get('/appointments_index_cliente', [AppointmentController::class, 'index_client']);
    Route::post('/appointments_store_cliente', [AppointmentController::class, 'store_client']);
    Route::post('/appointments_cancel_cliente/{id}', [AppointmentController::class, 'cancel_appointment_client']);
});

    
    


    // Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    
    
    // Route::get('/appointments', [AppointmentController::class, 'index']);
    // Route::post('/appointments', [AppointmentController::class, 'store']);
    // Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    // Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    
   
    
    
    // Route::get('/barbers', [BarberController::class, 'index']);
    // Route::get('/barbers/{id}', [BarberController::class, 'show']);
    // Route::post('/barbers', [BarberController::class, 'store']);
    // Route::put('/barbers/{id}', [BarberController::class, 'update']);
    // Route::delete('/barbers/{id}', [BarberController::class, 'destroy']);

   




