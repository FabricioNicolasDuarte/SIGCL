<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Training;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', ['header' => 'Salón Holográfico de Transmisión'])]
class VirtualClassroom extends Component
{
    public $training;
    public $roomName;
    public $userName;

    public function mount($id)
    {
        $this->training = Training::findOrFail($id);

        // Seguridad: Generamos un código de sala único, encriptado e irrepetible para esta materia
        $this->roomName = 'SIGCL-PRO-MODULO-' . $this->training->id . '-' . md5($this->training->name);

        // Le enviamos a Jitsi el nombre real del usuario logueado para que no pregunte cómo se llama
        $this->userName = auth()->user()->name . ' ' . auth()->user()->last_name;
    }

    public function render()
    {
        return view('livewire.virtual-classroom');
    }
}
