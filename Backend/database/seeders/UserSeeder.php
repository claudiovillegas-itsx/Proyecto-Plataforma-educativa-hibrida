<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
     public function run(): void
    {
        // Crear profesor de prueba
        User::create([
            'name' => 'Profesor Demo',
            'email' => 'profesor@cloueduhub.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);

        // Crear estudiantes de prueba
        User::create([
            'name' => 'Estudiante 1',
            'email' => 'estudiante1@cloueduhub.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Estudiante 2',
            'email' => 'estudiante2@cloueduhub.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);

        // Crear usuarios adicionales con factory si existe
        // User::factory(10)->create();
    }
}


