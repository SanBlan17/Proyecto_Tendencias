<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AvailabilityController;

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
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware('auth:api', 'role:ADMIN')->group(function () {
    // Rutas para administración de citas
    Route::get('/appointments_index_admin', [AppointmentController::class, 'index_admin']);
    Route::delete('/appointments_destroy/{id}', [AppointmentController::class, 'destroy']);
    // Rutas para administración de usuarios
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Rutas para administración de barberos
    Route::get('/barbers', [BarberController::class, 'index']);
    Route::put('/barbers/{id}', [BarberController::class, 'update']);

    // Rutas para administración de servicios
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    // Rutas para administración de horarios
    Route::post('/schedules', [ScheduleController::class, 'store']);
    Route::get('/schedules/barber/{barberId}/date/{date}',[ScheduleController::class, 'getScheduleByDate']);
    
    

});

Route::middleware('auth:api', 'role:BARBERO')->group(function () {
    Route::get('/appointments_index_barbero', [AppointmentController::class, 'index_barber']);
    Route::put('/confirmed_appointment_barbero/{id}', [AppointmentController::class, 'confirmed_appointment_barbero']);
});

Route::middleware('auth:api', 'role:CLIENTE')->group(function () {
    Route::get('/appointments_index_cliente', [AppointmentController::class, 'index_client']);
    Route::post('/appointments_store_cliente', [AppointmentController::class, 'store_client']);
    Route::post('/appointments_cancel_cliente/{id}', [AppointmentController::class, 'cancel_appointment_client']);
});

    
Route::get('/barbers/{barberId}/available-slots',[AvailabilityController::class, 'getAvailableSlots']);    


    
    
    
    // Route::get('/appointments', [AppointmentController::class, 'index']);
    // Route::post('/appointments', [AppointmentController::class, 'store']);
    // Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    // Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    
   
    
    
    // Route::get('/barbers', [BarberController::class, 'index']);
    // Route::get('/barbers/{id}', [BarberController::class, 'show']);
    // Route::post('/barbers', [BarberController::class, 'store']);
    // Route::put('/barbers/{id}', [BarberController::class, 'update']);
    // Route::delete('/barbers/{id}', [BarberController::class, 'destroy']);

   




