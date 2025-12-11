<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TeamsService
{
    protected $webhookUrl;
    protected $clientId;
    protected $clientSecret;
    protected $tenantId;
    
    public function __construct()
    {
        $this->webhookUrl = config('services.teams.webhook_url');
        $this->clientId = config('services.teams.client_id');
        $this->clientSecret = config('services.teams.client_secret');
        $this->tenantId = config('services.teams.tenant_id');
    }

    /**
     * Send notification to Teams channel via webhook
     */
    public function sendNotification(string $title, string $message, array $facts = [])
    {
        if (empty($this->webhookUrl)) {
            Log::warning('Teams webhook URL not configured');
            return false;
        }

        $payload = [
            "@type" => "MessageCard",
            "@context" => "https://schema.org/extensions",
            "summary" => $title,
            "themeColor" => "0078D4",
            "title" => $title,
            "sections" => [
                [
                    "activityTitle" => $message,
                    "facts" => $facts,
                    "markdown" => true
                ]
            ]
        ];

        try {
            $response = Http::post($this->webhookUrl, $payload);
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Teams notification failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Notify about new task creation
     */
    public function notifyTaskCreated($task, $user)
    {
        return $this->sendNotification(
            '📝 Nueva Tarea Creada',
            "Se ha creado una nueva tarea en CloudEduHub",
            [
                [
                    "name" => "Título:",
                    "value" => $task->title
                ],
                [
                    "name" => "Creado por:",
                    "value" => $user->name . " (" . $user->role . ")"
                ],
                [
                    "name" => "Fecha:",
                    "value" => now()->format('Y-m-d H:i:s')
                ]
            ]
        );
    }

    /**
     * Notify about task update
     */
    public function notifyTaskUpdated($task, $user)
    {
        return $this->sendNotification(
            '✏️ Tarea Actualizada',
            "Se ha actualizado una tarea en CloudEduHub",
            [
                [
                    "name" => "Título:",
                    "value" => $task->title
                ],
                [
                    "name" => "Actualizado por:",
                    "value" => $user->name
                ],
                [
                    "name" => "Estado:",
                    "value" => $task->status ?? 'N/A'
                ]
            ]
        );
    }

    /**
     * Notify about task deletion
     */
    public function notifyTaskDeleted($taskTitle, $user)
    {
        return $this->sendNotification(
            '🗑️ Tarea Eliminada',
            "Se ha eliminado una tarea de CloudEduHub",
            [
                [
                    "name" => "Título:",
                    "value" => $taskTitle
                ],
                [
                    "name" => "Eliminado por:",
                    "value" => $user->name
                ]
            ]
        );
    }

    /**
     * Send daily summary
     */
    public function sendDailySummary($totalTasks, $completedTasks, $pendingTasks)
    {
        return $this->sendNotification(
            '📊 Resumen Diario - CloudEduHub',
            "Estadísticas del día",
            [
                [
                    "name" => "Total de tareas:",
                    "value" => (string)$totalTasks
                ],
                [
                    "name" => "Completadas:",
                    "value" => (string)$completedTasks
                ],
                [
                    "name" => "Pendientes:",
                    "value" => (string)$pendingTasks
                ]
            ]
        );
    }
}
