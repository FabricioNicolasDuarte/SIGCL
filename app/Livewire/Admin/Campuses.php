<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination; // 1. IMPORTAMOS EL MOTOR DE PAGINACIÓN
use App\Models\Campus;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', ['header' => 'Red de Sedes y Nodos'])]
class Campuses extends Component
{
    use WithPagination; // 2. ACTIVAMOS LA PAGINACIÓN EN EL COMPONENTE

    public $campus_id;
    public $name, $location, $latitude, $longitude;
    public $is_active = true;
    public $isOpen = false;

    public function render()
    {
        // 3. CAMBIAMOS get() POR paginate(10)
        $campuses = Campus::orderBy('id', 'desc')->paginate(10);
        return view('livewire.admin.campuses', compact('campuses'));
    }

    public function create()
    {
        $this->resetFields();
        $this->isOpen = true;

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
