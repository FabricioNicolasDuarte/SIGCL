<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // <-- Importamos la clase Rule de Laravel

#[Layout('layouts.app', ['header' => 'Gestión de Usuarios'])]
class UserManagement extends Component
{
    use WithPagination;

    public $user_id, $name, $last_name, $dni, $email, $phone, $password, $role;
    public $is_active = true;
    public $isOpen = false;

    // Reglas de validación base (Ahora preparadas para PostgreSQL)
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            // Usamos Rule::unique para que ignore inteligentemente solo si hay un ID numérico válido
            'dni' => ['nullable', 'string', 'max:20', Rule::unique('users', 'dni')->ignore($this->user_id ?: null)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user_id ?: null)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,name',
            // La contraseña solo es obligatoria si estamos creando un usuario nuevo
            'password' => $this->user_id ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    public function render()
    {
        // Traemos a los usuarios con sus roles
        $users = User::with('roles')->orderBy('id', 'desc')->paginate(10);
        $roles = Role::all(); // Traemos los roles disponibles (Admin, Profesor, Estudiante)

        return view('livewire.admin.user-management', compact('users', 'roles'));
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
        $this->user_id = null; // <-- Cambiamos texto vacío por null para que PostgreSQL no se queje
        $this->name = '';
        $this->last_name = '';
        $this->dni = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->role = '';
        $this->is_active = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'dni' => $this->dni,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_active' => $this->is_active,
        ];

        // Si se escribió una contraseña, la encriptamos y la guardamos
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $user = User::updateOrCreate(['id' => $this->user_id], $data);

        // Le asignamos el rol elegido (Spatie automáticamente borra el anterior si tenía uno)
        $user->syncRoles([$this->role]);

        session()->flash('message', $this->user_id ? 'Usuario actualizado con éxito.' : 'Usuario registrado con éxito.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->dni = $user->dni;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->is_active = $user->is_active;

        // Obtenemos el nombre del primer rol que tenga este usuario
        $this->role = $user->roles->first()->name ?? '';

        $this->isOpen = true;
    }

    public function delete($id)
    {
        // Evitamos que el Super Administrador se borre a sí mismo por accidente
        if (auth()->id() == $id) {
            session()->flash('error', 'No puedes eliminar tu propia cuenta.');
            return;
        }

        User::find($id)->delete();
        session()->flash('message', 'Usuario eliminado correctamente.');
    }
}
