<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Campus;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', ['header' => 'Red de Sedes y Nodos'])]
class CampusManagement extends Component
{
    use WithPagination;

    public $campus_id;
    public $name, $location, $latitude, $longitude;
    public $is_active = true;
    public $isOpen = false;

    public function render()
    {
        // Traemos las sedes con paginación
        $campuses = Campus::orderBy('id', 'desc')->paginate(10);

        // ¡OJO AQUÍ! Aseguramos que apunte a la vista correcta
        return view('livewire.admin.campus-management', compact('campuses'));
    }

    public function create()
    {
        $this->resetFields();
        $this->isOpen = true;

        // Disparamos el mapa hacia Formosa, Argentina por defecto
        $this->dispatch('open-map', [
            'lat' => -26.18489,
            'lng' => -58.17313,
            'hasMarker' => false
        ]);
    }

    public function edit($id)
    {
        $campus = Campus::findOrFail($id);
        $this->campus_id = $id;
        $this->name = $campus->name;
        $this->location = $campus->location;
        $this->latitude = $campus->latitude;
        $this->longitude = $campus->longitude;
        $this->is_active = $campus->is_active;

        $this->isOpen = true;

        $this->dispatch('open-map', [
            'lat' => $campus->latitude ?? -26.18489,
            'lng' => $campus->longitude ?? -58.17313,
            'hasMarker' => $campus->latitude ? true : false
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);

        Campus::updateOrCreate(
            ['id' => $this->campus_id],
            [
                'name' => $this->name,
                'location' => $this->location,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'is_active' => $this->is_active ? true : false,
            ]
        );

        session()->flash('message', $this->campus_id ? 'Nodo reconfigurado con éxito en el sistema.' : 'Nuevo nodo establecido en la red.');

        $this->closeModal();
    }

    public function delete($id)
    {
        Campus::findOrFail($id)->delete();
        session()->flash('message', 'Nodo desconectado de la red permanentemente.');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->campus_id = null;
        $this->name = '';
        $this->location = '';
        $this->latitude = null;
        $this->longitude = null;
        $this->is_active = true;
    }
}
