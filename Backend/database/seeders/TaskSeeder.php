<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario de prueba
        $user = User::firstOrCreate(
            ['email' => 'estudiante@cloudeduhub.edu'],
            [
                'name' => 'Estudiante Ejemplo',
                'password' => bcrypt('password123')
            ]
        );

        // Crear usuario profesor
        $teacher = User::firstOrCreate(
            ['email' => 'profesor@cloudeduhub.edu'],
            [
                'name' => 'Profesor Ejemplo',
                'password' => bcrypt('password123')
            ]
        );

        // Tareas de ejemplo
        $tasks = [
            [
                'title' => 'Estudiar Cloud Computing',
                'description' => 'Fundamentos IaaS, PaaS, SaaS',
                'status' => 'in_progress',
                'priority' => 'high',
                'due_date' => now()->addDays(7),
                'user_id' => $user->id,
            ],
            [
                'title' => 'Configurar Azure',
                'description' => 'Crear cuenta Azure para estudiantes',
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => now()->addDays(3),
                'user_id' => $user->id,
            ]
        ];

        foreach ($tasks as $taskData) {
            Task::create($taskData);
        }

        echo 'Tareas creadas: ' . Task::count() . PHP_EOL;
    }
}