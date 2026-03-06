<?php

namespace App\Livewire\Teacher;

use Livewire\Component;
use App\Models\Training;
use App\Models\Enrollment;
use App\Models\Attendance;
use App\Models\CourseClass;
use App\Models\Evaluation;
use App\Models\Grade;
use App\Notifications\SystemAlert;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', ['header' => 'Terminal de Instrucción'])]
class MyClasses extends Component
{
    public $scanResult = null;
    public $scanStatus = '';
    public $scanMode = 'entry';

    // --- VARIABLES PARA EVALUACIONES Y NOTAS ---
    public $isEvalModalOpen = false;
    public $activeTrainingId = null;
    public $newEvalName = '';
    public $newEvalMaxScore = 10;
    public $newEvalDate = '';
    public $gradesData = [];

    // --- VARIABLES PARA EL MEGÁFONO DE ANUNCIOS ---
    public $isAnnouncementModalOpen = false;
    public $announcementTrainingId = null;
    public $announcementMessage = '';

    public function render()
    {
        $myClasses = Training::with([
            'campus',
            'courseClasses' => function($q) { $q->orderBy('date', 'asc'); },
            'evaluations' => function($q) { $q->orderBy('date', 'asc'); },
            'enrollments.student',
            'enrollments.attendances',
            'enrollments.grades'
        ])
        ->where('teacher_id', auth()->id())
        ->orderBy('start_date', 'desc')
        ->get();

        if (empty($this->gradesData)) {
            foreach($myClasses as $class) {
                foreach($class->enrollments as $enrollment) {
                    foreach($class->evaluations as $eval) {
                        $grade = $enrollment->grades->where('evaluation_id', $eval->id)->first();
                        $this->gradesData[$enrollment->id][$eval->id] = $grade ? $grade->score : '';
                    }
                }
            }
        }

        return view('livewire.teacher.my-classes', compact('myClasses'));
    }

    // --- MOTOR DE ESCÁNER BIOMÉTRICO ---
    public function processQR($token)
    {
        if (str_starts_with($token, 'SIGCL-ATTENDANCE-')) {
            $parts = explode('-', $token);

            if (count($parts) >= 5) {
                $studentId = $parts[2];
                $courseClassId = $parts[3];
                $timestamp = $parts[4];

                if (now()->timestamp - $timestamp > 600) {
                    $this->scanStatus = 'error'; $this->scanResult = 'CÓDIGO CADUCADO.'; return;
                }

                $courseClass = CourseClass::with('training')->find($courseClassId);
                if (!$courseClass || $courseClass->training->teacher_id !== auth()->id()) {
                    $this->scanStatus = 'error'; $this->scanResult = 'ACCESO DENEGADO: Clase inválida o no te pertenece.'; return;
                }

                $enrollment = Enrollment::where('student_id', $studentId)->where('training_id', $courseClass->training_id)->first();
                if (!$enrollment) {
                    $this->scanStatus = 'error'; $this->scanResult = 'El alumno no pertenece a este curso.'; return;
                }

                $attendance = Attendance::where('enrollment_id', $enrollment->id)->where('course_class_id', $courseClassId)->first();

                if ($this->scanMode === 'entry') {
                    if ($attendance) {
                        $this->scanStatus = 'error'; $this->scanResult = 'El alumno ya registró ENTRADA para esta clase.'; return;
                    }
                    Attendance::create([
                        'enrollment_id' => $enrollment->id,
                        'course_class_id' => $courseClassId,
                        'entry_time' => now()->toTimeString(),
                        'status' => 'present'
                    ]);
                    $this->scanStatus = 'success'; $this->scanResult = '¡ENTRADA REGISTRADA! ' . $enrollment->student->name;
                    return;
                } else {
                    if (!$attendance) {
                        $this->scanStatus = 'error'; $this->scanResult = 'ERROR: No hay entrada previa para registrar salida.'; return;
                    }
                    if ($attendance->exit_time) {
                        $this->scanStatus = 'error'; $this->scanResult = 'El alumno ya registró su SALIDA.'; return;
                    }
                    $attendance->update(['exit_time' => now()->toTimeString()]);
                    $this->scanStatus = 'success'; $this->scanResult = '¡SALIDA REGISTRADA! ' . $enrollment->student->name;
                    return;
                }
            }
        }
        $this->scanStatus = 'error'; $this->scanResult = 'CÓDIGO INVÁLIDO.';
    }

    public function resetScanner()
    {
        $this->scanResult = null; $this->scanStatus = '';
    }

    // --- MOTOR DE EVALUACIONES Y CALIFICACIONES ---
    public function openEvalModal($trainingId)
    {
        $this->activeTrainingId = $trainingId;
        $this->newEvalName = '';
        $this->newEvalMaxScore = 10;
        $this->newEvalDate = '';
        $this->isEvalModalOpen = true;
    }

    public function closeEvalModal()
    {
        $this->isEvalModalOpen = false;
        $this->activeTrainingId = null;
    }

    public function addEvaluation()
    {
        $this->validate([
            'newEvalName' => 'required|string|max:255',
            'newEvalMaxScore' => 'required|numeric|min:1',
            'newEvalDate' => 'required|date',
        ]);

        Evaluation::create([
            'training_id' => $this->activeTrainingId,
            'name' => $this->newEvalName,
            'max_score' => $this->newEvalMaxScore,
            'date' => $this->newEvalDate,
        ]);

        $this->gradesData = []; // Vaciamos para forzar recarga de la BD
        session()->flash('message', 'Evaluación programada exitosamente.');
        $this->closeEvalModal();
    }

    public function deleteEvaluation($id)
    {
        Evaluation::findOrFail($id)->delete();
        $this->gradesData = [];
        session()->flash('message', 'Evaluación eliminada del sistema.');
    }

    public function saveGrades($trainingId)
    {
        $training = Training::with('enrollments.student')->findOrFail($trainingId);

        foreach ($training->enrollments as $enrollment) {
            if(isset($this->gradesData[$enrollment->id])) {
                foreach ($this->gradesData[$enrollment->id] as $evalId => $score) {
                    if ($score !== '' && $score !== null) {
                        $grade = Grade::updateOrCreate(
                            ['enrollment_id' => $enrollment->id, 'evaluation_id' => $evalId],
                            ['score' => $score]
                        );

                        // NOTIFICAR AL ALUMNO
                        $eval = Evaluation::find($evalId);
                        $enrollment->student->notify(new SystemAlert(
                            'Calificación Registrada',
                            "El profesor ha publicado tu nota ({$score}) en '{$eval->name}' de la materia {$training->name}.",
                            'success'
                        ));

                    } else {
                        Grade::where('enrollment_id', $enrollment->id)->where('evaluation_id', $evalId)->delete();
                    }
                }
            }
        }
        session()->flash('message', 'Registro de calificaciones guardado correctamente y alumnos notificados.');
    }

    // --- EL MEGÁFONO DE ANUNCIOS ---
    public function openAnnouncementModal($trainingId)
    {
        $this->announcementTrainingId = $trainingId;
        $this->announcementMessage = '';
        $this->isAnnouncementModalOpen = true;
    }

    public function closeAnnouncementModal()
    {
        $this->isAnnouncementModalOpen = false;
        $this->announcementTrainingId = null;
        $this->announcementMessage = '';
    }

    public function sendAnnouncement()
    {
        $this->validate([
            'announcementMessage' => 'required|string|max:500'
        ]);

        $training = Training::with('enrollments.student')->findOrFail($this->announcementTrainingId);

        foreach ($training->enrollments as $enrollment) {
            if ($enrollment->student) {
                // Disparamos la alerta push a la campanita del alumno (tipo 'info' - color cyan)
                $enrollment->student->notify(new SystemAlert(
                    "Anuncio de {$training->name}",
                    $this->announcementMessage,
                    'info'
                ));
            }
        }

        session()->flash('message', 'Anuncio enviado a todos los alumnos matriculados al instante.');
        $this->closeAnnouncementModal();
    }
}
