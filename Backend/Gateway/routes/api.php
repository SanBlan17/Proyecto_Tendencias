<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\BarberController;

/*
|--------------------------------------------------------------------------
| API Routes - Gateway
|--------------------------------------------------------------------------
|
| Este es el punto de entrada centralizado para todos los microservicios.
| Aquí se manejan las peticiones del frontend y se enrutan a los servicios correspondientes.
|
*/

// ==================== Rutas de Autenticación ====================
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/verify', [AuthController::class, 'verify'])->middleware('auth:sanctum');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// ==================== Rutas Protegidas ====================
Route::middleware('auth:sanctum')->group(function () {
    
    // ==================== Rutas de Citas ====================
    Route::prefix('appointments')->group(function () {
        Route::get('/', [AppointmentController::class, 'index']);
        Route::post('/', [AppointmentController::class, 'store']);
        Route::get('/{id}', [AppointmentController::class, 'show']);
        Route::put('/{id}', [AppointmentController::class, 'update']);
        Route::delete('/{id}', [AppointmentController::class, 'destroy']);
    });

    // ==================== Rutas de Barberos/Servicios ====================
    Route::prefix('barbers')->group(function () {
        Route::get('/', [BarberController::class, 'index']);
        Route::post('/', [BarberController::class, 'store']);
        Route::get('/{id}', [BarberController::class, 'show']);
        Route::put('/{id}', [BarberController::class, 'update']);
        Route::delete('/{id}', [BarberController::class, 'destroy']);
    });

});

