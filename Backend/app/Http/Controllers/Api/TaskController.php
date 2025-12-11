<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\TeamsService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $teamsService;

    public function __construct(TeamsService $teamsService)
    {
        $this->teamsService = $teamsService;
    }

    /**
     * Display a listing of tasks
     */
    public function index(Request $request)
    {
        $query = Task::with('user');

        // Filtrar por rol
        if ($request->user()->isStudent()) {
            // Los estudiantes solo ven sus propias tareas
            $query->where('user_id', $request->user()->id);
        }
        // Los profesores ven todas las tareas

        $tasks = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    /**
     * Store a newly created task
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
            'due_date' => $request->due_date,
            'user_id' => $request->user()->id,
        ]);

        // Notificar a Teams
        $this->teamsService->notifyTaskCreated($task, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully',
            'data' => $task
        ], 201);
    }

    /**
     * Display the specified task
     */
    public function show(Request $request, Task $task)
    {
        // Verificar permisos
        if ($request->user()->isStudent() && $task->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to view this task'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $task->load('user')
        ]);
    }

    /**
     * Update the specified task
     */
    public function update(Request $request, Task $task)
    {
        // Verificar permisos
        if ($request->user()->isStudent() && $task->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this task'
            ], 403);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($request->only(['title', 'description', 'status', 'due_date']));

        // Notificar a Teams
        $this->teamsService->notifyTaskUpdated($task, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $task
        ]);
    }

    /**
     * Remove the specified task
     */
    public function destroy(Request $request, Task $task)
    {
        // Solo profesores o el dueño pueden eliminar
        if ($request->user()->isStudent() && $task->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this task'
            ], 403);
        }

        $taskTitle = $task->title;
        $task->delete();

        // Notificar a Teams
        $this->teamsService->notifyTaskDeleted($taskTitle, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    }

    /**
     * Get tasks statistics (solo para profesores)
     */
    public function statistics(Request $request)
    {
        if ($request->user()->isStudent()) {
            return response()->json([
                'success' => false,
                'message' => 'Only teachers can view statistics'
            ], 403);
        }

        $stats = [
            'total' => Task::count(),
            'pending' => Task::where('status', 'pending')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed' => Task::where('status', 'completed')->count(),
            'by_user' => Task::selectRaw('user_id, count(*) as count')
                ->groupBy('user_id')
                ->with('user:id,name,email')
                ->get()
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
