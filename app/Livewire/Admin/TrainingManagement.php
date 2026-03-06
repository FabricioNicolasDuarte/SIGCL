<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Training;
use App\Models\Campus;
use App\Models\User;
use App\Models\CourseClass;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', ['header' => 'Gestión de Módulos y Cronogramas'])]
class TrainingManagement extends Component
{
    use WithPagination;

    public $training_id;
    public $name, $description, $campus_id, $teacher_id, $capacity = 30, $start_date, $end_date;
    public $is_active = true;
    public $isOpen = false;

    // MATRIZ TEMPORAL PARA LAS CLASES
    public $scheduled_classes = [];

    public function render()
    {
        // Traemos los cursos y sus clases programadas
        $trainings = Training::with(['campus', 'teacher', 'courseClasses'])->orderBy('id', 'desc')->paginate(10);
        $campuses = Campus::where('is_active', true)->get();
        $teachers = User::role('profesor')->where('is_active', true)->get();

        return view('livewire.admin.training-management', compact('trainings', 'campuses', 'teachers'));
    }

    public function create()
    {
        $this->resetFields();
        // Por defecto, le damos 1 clase vacía para empezar a programar
        $this->scheduled_classes = [['name' => 'Clase 1: Introducción', 'date' => '']];
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $this->resetFields();
        $training = Training::with('courseClasses')->findOrFail($id);

        $this->training_id = $id;
        $this->name = $training->name;
        $this->description = $training->description;
        $this->campus_id = $training->campus_id;
        $this->teacher_id = $training->teacher_id;
        $this->capacity = $training->capacity;
        $this->start_date = $training->start_date ? $training->start_date->format('Y-m-d') : null;
        $this->end_date = $training->end_date ? $training->end_date->format('Y-m-d') : null;
        $this->is_active = $training->is_active;

        // Cargamos las clases que ya estaban guardadas
        foreach($training->courseClasses as $courseClass) {
            $this->scheduled_classes[] = [
                'id' => $courseClass->id,
                'name' => $courseClass->name,
                'date' => $courseClass->date
            ];
        }

        if(empty($this->scheduled_classes)) {
            $this->scheduled_classes = [['name' => 'Clase 1', 'date' => '']];
        }

        $this->isOpen = true;
    }

    // BOTÓN PARA AÑADIR UNA NUEVA CLASE A LA LISTA
    public function addClass()
    {
        $nextNumber = count($this->scheduled_classes) + 1;
        $this->scheduled_classes[] = ['name' => 'Clase ' . $nextNumber, 'date' => ''];
    }

    // BOTÓN PARA QUITAR UNA CLASE DE LA LISTA
    public function removeClass($index)
    {
        unset($this->scheduled_classes[$index]);
        $this->scheduled_classes = array_values($this->scheduled_classes); // Reacomodar los índices
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'campus_id' => 'required|exists:campuses,id',
            'teacher_id' => 'required|exists:users,id',
            'capacity' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'scheduled_classes.*.name' => 'required|string',
            'scheduled_classes.*.date' => 'required|date', // Exigimos que todas las clases tengan fecha
        ], [
            'scheduled_classes.*.date.required' => 'Todas las clases programadas deben tener una fecha asignada.'
        ]);

        $training = Training::updateOrCreate(
            ['id' => $this->training_id],
            [
                'name' => $this->name,
                'description' => $this->description,
                'campus_id' => $this->campus_id,
                'teacher_id' => $this->teacher_id,
                'capacity' => $this->capacity,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'is_active' => $this->is_active ? true : false,
            ]
        );

        // --- MOTOR DE SINCRONIZACIÓN DE CLASES ---
        // 1. Vemos qué clases dejó el administrador en la pantalla
        $keptClassIds = collect($this->scheduled_classes)->pluck('id')->filter()->toArray();

        // 2. Borramos de la BD las clases que el Admin eliminó clickeando la "X"
        $training->courseClasses()->whereNotIn('id', $keptClassIds)->delete();

        // 3. Guardamos o actualizamos las clases
        foreach ($this->scheduled_classes as $classData) {
            if (isset($classData['id'])) {
                CourseClass::where('id', $classData['id'])->update([
                    'name' => $classData['name'],
                    'date' => $classData['date'],
                ]);
            } else {
                $training->courseClasses()->create([
                    'name' => $classData['name'],
                    'date' => $classData['date'],
                ]);
            }
        }

        session()->flash('message', $this->training_id ? 'Módulo y cronograma reconfigurados.' : 'Nuevo módulo establecido con su cronograma de clases.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Training::findOrFail($id)->delete();
        session()->flash('message', 'Módulo y sus clases eliminados de la red.');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->training_id = null;
        $this->name = '';
        $this->description = '';
        $this->campus_id = '';
        $this->teacher_id = '';
        $this->capacity = 30;
        $this->start_date = null;
        $this->end_date = null;
        $this->is_active = true;
        $this->scheduled_classes = [];
    }
}
