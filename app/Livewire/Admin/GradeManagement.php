<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Training;
use App\Models\Evaluation;
use App\Models\Grade;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', ['header' => 'Centro de Calificaciones'])]
class GradeManagement extends Component
{
    public $trainings, $selectedTrainingId = '';
    public $evaluations = [], $enrollments = [];

    // Para crear nuevas evaluaciones
    public $newEvalName = '';
    public $newEvalMaxScore = 10; // Por defecto nota sobre 10

    // Matriz de notas [enrollment_id => [evaluation_id => score]]
    public $gradesData = [];

    public function mount()
    {
        // Traemos todos los cursos activos
        $this->trainings = Training::where('is_active', true)->orderBy('id', 'desc')->get();
    }

    // Se ejecuta automáticamente cuando el admin elige un curso en el select
    public function updatedSelectedTrainingId()
    {
        $this->loadCourseData();
    }

    public function loadCourseData()
    {
        if (!$this->selectedTrainingId) {
            $this->evaluations = [];
            $this->enrollments = [];
            return;
        }

        $training = Training::with(['evaluations', 'enrollments.student', 'enrollments.grades'])->findOrFail($this->selectedTrainingId);

        $this->evaluations = $training->evaluations;
        $this->enrollments = $training->enrollments;
        $this->gradesData = [];

        // Armamos la matriz de notas actual para que los inputs se llenen con lo que ya está en BD
        foreach ($this->enrollments as $enrollment) {
            foreach ($this->evaluations as $eval) {
                $grade = $enrollment->grades->where('evaluation_id', $eval->id)->first();
                $this->gradesData[$enrollment->id][$eval->id] = $grade ? $grade->score : '';
            }
        }
    }

    public function addEvaluation()
    {
        $this->validate([
            'selectedTrainingId' => 'required',
            'newEvalName' => 'required|string|max:255',
            'newEvalMaxScore' => 'required|numeric|min:1',
        ]);

        Evaluation::create([
            'training_id' => $this->selectedTrainingId,
            'name' => $this->newEvalName,
            'max_score' => $this->newEvalMaxScore
        ]);

        $this->newEvalName = '';
        $this->loadCourseData(); // Recargar la tabla
        session()->flash('message', 'Evaluación configurada correctamente.');
    }

    public function deleteEvaluation($id)
    {
        Evaluation::findOrFail($id)->delete();
        $this->loadCourseData();
        session()->flash('message', 'Evaluación eliminada del sistema.');
    }

    public function saveGrades()
    {
        // Recorremos la matriz que viene de los inputs de la tabla
        foreach ($this->gradesData as $enrollmentId => $evals) {
            foreach ($evals as $evalId => $score) {
                if ($score !== '' && $score !== null) {
                    Grade::updateOrCreate(
                        ['enrollment_id' => $enrollmentId, 'evaluation_id' => $evalId],
                        ['score' => $score]
                    );
                } else {
                    // Si el admin borra la nota (deja el input vacío), la borramos de la BD
                    Grade::where('enrollment_id', $enrollmentId)->where('evaluation_id', $evalId)->delete();
                }
            }

            // Aquí podríamos calcular el final_grade del enrollment en el futuro
        }

        session()->flash('message', 'Registro de notas actualizado en la base de datos.');
        $this->loadCourseData();
    }

    public function render()
    {
        return view('livewire.admin.grade-management');
    }
}
