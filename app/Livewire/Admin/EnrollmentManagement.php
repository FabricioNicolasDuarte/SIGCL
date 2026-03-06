<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Enrollment;
use App\Models\Training;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', ['header' => 'Gestión de Inscripciones'])]
class EnrollmentManagement extends Component
{
    use WithPagination;

    public $enrollment_id, $training_id, $student_id, $status = 'enrolled', $final_grade;
    public $isOpen = false;

    protected function rules()
    {
        return [
            'training_id' => 'required|exists:trainings,id',
            'student_id' => 'required|exists:users,id',
            'status' => 'required|in:enrolled,completed,dropped',
            'final_grade' => 'nullable|numeric|min:0|max:100', // Nota del 0 al 100
        ];
    }

    public function render()
    {
        // Traemos las inscripciones con los datos del curso y del alumno
        $enrollments = Enrollment::with(['training', 'student'])->orderBy('id', 'desc')->paginate(10);

        // Traemos solo los cursos activos
        $trainings = Training::where('is_active', true)->get();

        // Magia de Spatie: Traemos SOLO a los usuarios que tengan el rol "estudiante"
        $students = User::role('estudiante')->where('is_active', true)->get();

        return view('livewire.admin.enrollment-management', compact('enrollments', 'trainings', 'students'));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetValidation();
    }

    private function resetInputFields()
    {
        $this->enrollment_id = '';
        $this->training_id = '';
        $this->student_id = '';
        $this->status = 'enrolled';
        $this->final_grade = '';
    }

    public function store()
    {
        $this->validate();

        // Evitar que inscriban al mismo alumno dos veces en el mismo curso
        if (!$this->enrollment_id) {
            $exists = Enrollment::where('training_id', $this->training_id)
                                ->where('student_id', $this->student_id)
                                ->exists();
            if ($exists) {
                $this->addError('student_id', 'Este estudiante ya está inscrito en este curso.');
                return;
            }
        }

        Enrollment::updateOrCreate(['id' => $this->enrollment_id], [
            'training_id' => $this->training_id,
            'student_id' => $this->student_id,
            'status' => $this->status,
            'final_grade' => $this->final_grade !== '' ? $this->final_grade : null,
        ]);

        session()->flash('message', $this->enrollment_id ? 'Inscripción actualizada.' : 'Estudiante inscrito con éxito.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $this->enrollment_id = $id;
        $this->training_id = $enrollment->training_id;
        $this->student_id = $enrollment->student_id;
        $this->status = $enrollment->status;
        $this->final_grade = $enrollment->final_grade;

        $this->isOpen = true;
    }

    public function delete($id)
    {
        Enrollment::find($id)->delete();
        session()->flash('message', 'Inscripción eliminada correctamente.');
    }
}
