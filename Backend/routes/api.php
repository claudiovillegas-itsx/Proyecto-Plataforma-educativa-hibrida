<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

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

// Rutas públicas (sin autenticación)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });

    // Task routes - todos los usuarios autenticados
    Route::apiResource('tasks', TaskController::class);
    
    // Estadísticas - solo profesores
    Route::get('tasks-statistics', [TaskController::class, 'statistics'])
        ->middleware('role:teacher');
        
    // Ejemplos de rutas con roles específicos
    Route::middleware('role:teacher')->group(function () {
        // Rutas solo para profesores
        // Route::get('/admin/dashboard', ...);
    });
    
    Route::middleware('role:student')->group(function () {
        // Rutas solo para estudiantes
        // Route::get('/student/profile', ...);
    });
});
