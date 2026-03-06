<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Enrollment;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Carbon\Carbon;

#[Layout('layouts.app', ['header' => 'Terminal de Estudiante'])]
class MyCourses extends Component
{
    public $qrToken = null;
    public $showQr = false;
    public $activeCourseName = '';

    public $aiQuery = '';
    public $chatHistory = [];

    public function mount()
    {
        $this->chatHistory[] = [
            'sender' => 'ai',
            'text' => 'Saludos, ' . auth()->user()->name . '. Mi red neuronal ha sido actualizada a la versión 2.0. Puedes preguntarme por tus "notas", tus "asistencias" o tus "próximas clases".'
        ];
    }

    public function render()
    {
        // Traemos todo el ecosistema de datos del alumno
        $enrollments = Enrollment::with([
            'training.campus',
            'training.teacher',
            'training.courseClasses' => function($q) { $q->orderBy('date', 'asc'); },
            'training.evaluations' => function($q) { $q->orderBy('date', 'asc'); },
            'attendances',
            'grades'
        ])
        ->where('student_id', auth()->id())
        ->orderBy('id', 'desc')
        ->get();

        return view('livewire.student.my-courses', compact('enrollments'));
    }

    public function generateQR($courseClassId, $className)
    {
        $this->qrToken = 'SIGCL-ATTENDANCE-' . auth()->id() . '-' . $courseClassId . '-' . now()->timestamp . '-' . Str::random(5);
        $this->activeCourseName = $className;
        $this->showQr = true;
    }

    public function closeQR()
    {
        $this->showQr = false;
        $this->qrToken = null;
    }

    // --- EL NUEVO CEREBRO DE LA IA ---
    public function askAI()
    {
        if (trim($this->aiQuery) === '') return;

        $pregunta = $this->aiQuery;
        // Guardamos la pregunta del alumno en el historial
        $this->chatHistory[] = ['sender' => 'user', 'text' => $pregunta];
        $this->aiQuery = '';

        $preguntaLower = strtolower($pregunta);
        $respuesta = "";

        $enrollments = Enrollment::with([
            'training.evaluations',
            'training.courseClasses',
            'grades',
            'attendances'
        ])->where('student_id', auth()->id())->get();

        if ($enrollments->isEmpty()) {
            $respuesta = "No detecto que estés matriculado en ningún módulo activo en la red.";
        } else {
            // 1. EL ALUMNO PREGUNTA POR NOTAS / CALIFICACIONES
            if (str_contains($preguntaLower, 'nota') || str_contains($preguntaLower, 'calificación') || str_contains($preguntaLower, 'calificaciones') || str_contains($preguntaLower, 'promedio')) {
                $respuesta = "He escaneado el libro de calificaciones. Este es tu estado actual: ";
                $notasArray = [];

                foreach ($enrollments as $enrollment) {
                    $materia = $enrollment->training->name;
                    $evals = [];
                    foreach ($enrollment->training->evaluations as $eval) {
                        $grade = $enrollment->grades->where('evaluation_id', $eval->id)->first();
                        $nota = $grade ? $grade->score : 'Pendiente';
                        $evals[] = "{$eval->name}: {$nota}";
                    }
                    $notasTexto = empty($evals) ? "Aún no hay evaluaciones programadas" : implode(", ", $evals);
                    $notasArray[] = "[ {$materia} -> $notasTexto ]";
                }
                $respuesta .= implode(" | ", $notasArray) . ".";
            }
            // 2. EL ALUMNO PREGUNTA POR ASISTENCIAS / FALTAS
            elseif (str_contains($preguntaLower, 'asistencia') || str_contains($preguntaLower, 'falta') || str_contains($preguntaLower, 'presente')) {
                $respuesta = "Analizando tu biometría de asistencias... ";
                $asistenciasArray = [];

                foreach ($enrollments as $enrollment) {
                    $materia = $enrollment->training->name;
                    $totalClases = $enrollment->training->courseClasses->count();
                    $asistencias = $enrollment->attendances->count();
                    $asistenciasArray[] = "[ {$materia}: {$asistencias} presentes de {$totalClases} clases ]";
                }
                $respuesta .= implode(" | ", $asistenciasArray) . ".";
            }
            // 3. EL ALUMNO PREGUNTA POR LA AGENDA / PRÓXIMAS CLASES
            elseif (str_contains($preguntaLower, 'clase') || str_contains($preguntaLower, 'fecha') || str_contains($preguntaLower, 'cuándo')) {
                $respuesta = "Accediendo al cronograma oficial... ";
                $clasesArray = [];

                foreach ($enrollments as $enrollment) {
                    $materia = $enrollment->training->name;
                    // Buscamos la clase cuya fecha sea HOY o en el FUTURO
                    $proximaClase = $enrollment->training->courseClasses->where('date', '>=', now()->toDateString())->sortBy('date')->first();

                    if ($proximaClase) {
                        $fechaFormat = Carbon::parse($proximaClase->date)->format('d/m/Y');
                        $clasesArray[] = "[ {$materia}: '{$proximaClase->name}' programada para el {$fechaFormat} ]";
                    }
                }
                $respuesta .= empty($clasesArray) ? "No tienes clases futuras programadas en el sistema." : implode(" | ", $clasesArray) . ".";
            }
            // 4. NO ENTENDIÓ LA PREGUNTA
            else {
                $respuesta = "Mis protocolos no logran procesar esa consulta. Te sugiero preguntarme sobre tus 'notas', tu nivel de 'asistencia' o 'cuándo' son tus próximas clases.";
            }
        }

        // Devolvemos la respuesta de la IA
        $this->chatHistory[] = ['sender' => 'ai', 'text' => $respuesta];
    }
}
