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

// ==================== Rutas de Autenticación (Sin Protección) ====================

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');


// ==================== Rutas Protegidas (Requieren JWT Token) ====================
Route::middleware('auth:api')->group(function () {
    
    // ==================== Rutas de Autenticación (Con Protección) ====================
    
    Route::post('/verify', [AuthController::class, 'verify'])->name('auth.verify');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
    
    
    // ==================== Rutas de Citas ====================
    Route::prefix('appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'index']);
    Route::post('/', [AppointmentController::class, 'store']);
    Route::get('/{id}', [AppointmentController::class, 'show']);
    Route::put('/{id}', [AppointmentController::class, 'update']);
    Route::delete('/{id}', [AppointmentController::class, 'destroy']);
   
    // ==================== Rutas de Barberos/Servicios ====================
    
    Route::get('/', [BarberController::class, 'index']);
    Route::get('/{id}', [BarberController::class, 'show']);
    Route::post('/', [BarberController::class, 'store']);
    Route::put('/{id}', [BarberController::class, 'update']);
    Route::delete('/{id}', [BarberController::class, 'destroy']);

    });

});


