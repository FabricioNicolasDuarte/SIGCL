<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Campus;
use App\Models\Training;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CREAR ROLES
        $roleSuperAdmin = Role::create(['name' => 'super_admin']);
        $roleTeacher = Role::create(['name' => 'profesor']);
        $roleStudent = Role::create(['name' => 'estudiante']);

        // 2. CREAR SÚPER ADMINISTRADOR
        $admin = User::create([
            'name' => 'Super',
            'last_name' => 'Administrador',
            'email' => 'admin@email.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $admin->assignRole($roleSuperAdmin);

        // 3. CREAR PROFESOR DE PRUEBA
        $teacher = User::create([
            'name' => 'Docente',
            'last_name' => 'Prueba',
            'email' => 'profesor@email.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $teacher->assignRole($roleTeacher);

        // 4. CREAR ESTUDIANTE DE PRUEBA
        $student = User::create([
            'name' => 'Alumno',
            'last_name' => 'Prueba',
            'dni' => '12345678',
            'email' => 'estudiante@email.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $student->assignRole($roleStudent);

        // 5. CREAR UNA SEDE FÍSICA
        $campus = Campus::create([
            'name' => 'Base Lunar Alpha',
            'location' => 'Mar de la Tranquilidad',
            'latitude' => 0.681400,
            'longitude' => 23.460550,
            'is_active' => true,
        ]);

        // 6. CREAR UN CURSO (Asignado al profe y a la sede)
        $training = Training::create([
            'name' => 'Ingeniería de Sistemas Cyberpunk',
            'description' => 'Curso avanzado de biometría y redes neuronales.',
            'campus_id' => $campus->id,
            'teacher_id' => $teacher->id,
            'capacity' => 30,
            'start_date' => now()->addDays(2),
            'end_date' => now()->addMonths(3),
            'is_active' => true,
        ]);

        // 7. MATRICULAR AL ALUMNO EN EL CURSO
        Enrollment::create([
            'student_id' => $student->id,
            'training_id' => $training->id,
            'status' => 'enrolled',
            'final_grade' => null,
        ]);
    }
}
