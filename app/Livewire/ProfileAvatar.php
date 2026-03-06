<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProfileAvatar extends Component
{
    use WithFileUploads;

    public $photo;

    public function save()
    {
        $this->validate(['photo' => 'image|max:2048']); // Máximo 2MB

        $user = auth()->user();

        // Si ya tenía foto vieja, la borramos del servidor
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Guardamos la nueva foto
        $path = $this->photo->store('avatars', 'public');
        $user->update(['profile_photo_path' => $path]);

        $this->dispatch('profile-updated'); // Avisa al navegador que actualice la foto
        session()->flash('message', 'Foto de perfil actualizada exitosamente.');
    }

    public function render()
    {
        return view('livewire.profile-avatar');
    }
}
