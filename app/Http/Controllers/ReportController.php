<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // --- 1. ACTA OFICIAL PARA EL PROFESOR ---
    public function exportTrainingMatrix($id)
    {
        $training = Training::with([
            'campus',
            'teacher',
            'courseClasses' => function($q) { $q->orderBy('date', 'asc'); },
            'evaluations' => function($q) { $q->orderBy('date', 'asc'); },
            'enrollments.student',
            'enrollments.attendances',
            'enrollments.grades'
        ])->findOrFail($id);

        if (auth()->user()->hasRole('profesor') && $training->teacher_id !== auth()->id()) {
            abort(403, 'ACCESO DENEGADO: Este módulo no te pertenece.');
        }

        $pdf = Pdf::loadView('reports.training-matrix', compact('training'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Acta_Oficial_' . str_replace(' ', '_', $training->name) . '.pdf');
    }

    // --- 2. CERTIFICADO ANALÍTICO PARA EL ALUMNO ---
    public function exportStudentCertificate($id)
    {
        $user = auth()->user();

        // Buscamos la matrícula exacta de este alumno para este curso
        $enrollment = Enrollment::with([
            'training.campus',
            'training.teacher',
            'training.evaluations',
            'grades',
            'attendances'
        ])
        ->where('student_id', $user->id)
        ->where('training_id', $id)
        ->firstOrFail();

        $training = $enrollment->training;

        // Generamos el PDF con orientación vertical (Portrait)
        $pdf = Pdf::loadView('reports.student-certificate', compact('user', 'enrollment', 'training'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Certificado_Analitico_' . str_replace(' ', '_', $training->name) . '.pdf');
    }
}
