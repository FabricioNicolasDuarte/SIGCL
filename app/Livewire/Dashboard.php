<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Training;
use App\Models\Campus;
use App\Models\Enrollment;
use App\Models\Attendance;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.app', ['header' => 'Centro de Comando Global'])]
class Dashboard extends Component
{
    public function render()
    {
        // 1. ESTADÍSTICAS BASE (SUPER ADMIN)
        $totalStudents = User::role('estudiante')->where('is_active', true)->count();
        $totalTeachers = User::role('profesor')->where('is_active', true)->count();
        $activeCourses = Training::where('is_active', true)->count();
        $totalCampuses = Campus::where('is_active', true)->count();
        $totalEnrollments = Enrollment::count();

        // CORRECCIÓN: Buscamos la fecha haciendo un JOIN con la tabla de clases
        $todayAttendances = Attendance::join('course_classes', 'attendances.course_class_id', '=', 'course_classes.id')
            ->where('course_classes.date', now()->toDateString())
            ->count();

        $recentAttendances = Attendance::with(['enrollment.student', 'enrollment.training'])
            ->orderBy('id', 'desc')->take(5)->get();

        $recentEnrollments = Enrollment::with(['student', 'training'])
            ->orderBy('id', 'desc')->take(5)->get();

        // 2. DATA PARA GRÁFICOS (CHART.JS)
        // Gráfico 1: Asistencias de los últimos 7 días (CORREGIDO)
        $trendLabels = [];
        $trendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $trendLabels[] = $date->format('d/m');

            $trendData[] = Attendance::join('course_classes', 'attendances.course_class_id', '=', 'course_classes.id')
                ->where('course_classes.date', $date->toDateString())
                ->count();
        }

        // Gráfico 2: Top Cursos con más alumnos (Máximo 5)
        $topCourses = Training::withCount('enrollments')->orderByDesc('enrollments_count')->take(5)->get();
        $courseLabels = $topCourses->pluck('name')->toArray();
        $courseData = $topCourses->pluck('enrollments_count')->toArray();

        // 3. ESTADÍSTICAS PERSONALES (ESTUDIANTES Y PROFESORES)
        $myActiveCourses = 0;
        $myTotalAttendances = 0;

        if (auth()->user()->hasRole('estudiante')) {
            $myActiveCourses = Enrollment::where('student_id', auth()->id())->count();
            $myTotalAttendances = Attendance::whereHas('enrollment', function($q) {
                $q->where('student_id', auth()->id());
            })->count();
        } elseif (auth()->user()->hasRole('profesor')) {
            $myActiveCourses = Training::where('teacher_id', auth()->id())->where('is_active', true)->count();
        }

        return view('livewire.dashboard', compact(
            'totalStudents', 'totalTeachers', 'activeCourses', 'totalCampuses',
            'totalEnrollments', 'todayAttendances', 'recentAttendances', 'recentEnrollments',
            'trendLabels', 'trendData', 'courseLabels', 'courseData',
            'myActiveCourses', 'myTotalAttendances'
        ));
    }
}
