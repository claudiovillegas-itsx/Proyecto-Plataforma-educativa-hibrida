<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

// ===========================================
// RUTAS API PARA CLOUDEDUHUB
// ===========================================

Route::prefix('api')->group(function () {
    
    // Ruta de prueba/estado
    Route::get('/status', function () {
        return response()->json([
            'status' => 'active',
            'service' => 'CloudEduHub Backend API',
            'version' => '1.0.0',
            'timestamp' => now(),
            'endpoints' => [
                'GET /api/tasks' => 'Listar todas las tareas',
                'POST /api/tasks' => 'Crear nueva tarea',
                'GET /api/tasks/{id}' => 'Obtener una tarea',
                'PUT /api/tasks/{id}' => 'Actualizar tarea',
                'DELETE /api/tasks/{id}' => 'Eliminar tarea'
            ]
        ]);
    });
    
    // Rutas CRUD de Tareas
    Route::apiResource('tasks', TaskController::class);
    
    // Si quieres rutas individuales (en lugar de apiResource):
    /*
    Route::get('/tasks', [TaskController::class, 'index']);       // Listar
    Route::post('/tasks', [TaskController::class, 'store']);      // Crear
    Route::get('/tasks/{task}', [TaskController::class, 'show']); // Mostrar
    Route::put('/tasks/{task}', [TaskController::class, 'update']); // Actualizar
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']); // Eliminar
    */
});

// ===========================================
