<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Iniciar consulta con relación user
            $query = Task::with('user');
            
            // Filtros opcionales
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->has('priority')) {
                $query->where('priority', $request->priority);
            }
            
            if ($request->has('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }
            
            // Ordenamiento
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            
            // Obtener resultados
            $tasks = $query->get();
            
            return response()->json([
                'success' => true,
                'message' => '🎉 Tareas obtenidas exitosamente',
                'count' => $tasks->count(),
                'data' => $tasks,
                'database' => 'MySQL (' . config('database.connections.mysql.database') . ')',
                'timestamp' => now()->toDateTimeString()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener tareas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'nullable|in:pending,in_progress,completed',
            'priority' => 'nullable|in:low,medium,high',
            'due_date' => 'nullable|date|after_or_equal:today',
            'user_id' => 'required|exists:users,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $task = Task::create($validator->validated());
            
            return response()->json([
                'success' => true,
                'message' => '✅ Tarea creada exitosamente en MySQL',
                'data' => $task->load('user')
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear tarea',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $task = Task::with('user')->find($id);
            
            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tarea no encontrada'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $task
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener tarea',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Tarea no encontrada'
            ], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'sometimes|in:pending,in_progress,completed',
            'priority' => 'sometimes|in:low,medium,high',
            'due_date' => 'nullable|date',
            'user_id' => 'sometimes|exists:users,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $task->update($validator->validated());
            
            return response()->json([
                'success' => true,
                'message' => '🔄 Tarea actualizada',
                'data' => $task->fresh()->load('user')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar tarea',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Tarea no encontrada'
            ], 404);
        }
        
        try {
            $task->delete();
            
            return response()->json([
                'success' => true,
                'message' => '🗑️ Tarea eliminada exitosamente',
                'data' => [
                    'id' => $id,
                    'deleted_at' => now()->toDateTimeString()
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar tarea',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Endpoint adicional: Marcar tarea como completada
     */
    public function markAsCompleted(string $id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Tarea no encontrada'
            ], 404);
        }
        
        try {
            $task->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => '✅ Tarea marcada como completada',
                'data' => $task->fresh()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al completar tarea',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Endpoint adicional: Estadísticas
     */
    public function statistics()
    {
        try {
            $total = Task::count();
            $pending = Task::where('status', 'pending')->count();
            $completed = Task::where('status', 'completed')->count();
            $highPriority = Task::where('priority', 'high')->count();
            
            return response()->json([
                'success' => true,
                'message' => '📊 Estadísticas de tareas',
                'data' => [
                    'total_tasks' => $total,
                    'pending_tasks' => $pending,
                    'completed_tasks' => $completed,
                    'high_priority_tasks' => $highPriority,
                    'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
                    'database' => config('database.connections.mysql.database')
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}