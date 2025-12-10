<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => '✅ Endpoint GET /api/tasks funcionando',
            'data' => [
                'service' => 'CloudEduHub Backend',
                'endpoint' => '/api/tasks',
                'method' => 'GET',
                'timestamp' => now()->toDateTimeString(),
                'next_step' => 'Usa POST /api/tasks para crear una tarea'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación simple
        $data = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => '🎉 Tarea creada exitosamente (simulación)',
            'data' => [
                'id' => rand(100, 999),
                'title' => $data['title'],
                'description' => $data['description'] ?? 'Sin descripción',
                'status' => 'pending',
                'created_at' => now()->toDateTimeString(),
                'note' => 'Mañana conectaremos con MySQL'
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'success' => true,
            'message' => "📋 Detalles de tarea #{$id}",
            'data' => [
                'id' => (int)$id,
                'title' => 'Tarea de ejemplo para demostración',
                'description' => 'Esta es una tarea de prueba del sistema CloudEduHub',
                'status' => 'in_progress',
                'priority' => 'medium',
                'created_at' => '2024-12-09 14:30:00',
                'project' => 'CloudEduHub Mini'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json([
            'success' => true,
            'message' => "🔄 Tarea #{$id} actualizada",
            'data' => [
                'id' => (int)$id,
                'updated' => true,
                'changes' => $request->all(),
                'timestamp' => now()->toDateTimeString()
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json([
            'success' => true,
            'message' => "🗑️ Tarea #{$id} eliminada",
            'data' => [
                'id' => (int)$id,
                'deleted' => true,
                'timestamp' => now()->toDateTimeString(),
                'note' => 'En producción, esto borraría de la base de datos'
            ]
        ]);
    }
}