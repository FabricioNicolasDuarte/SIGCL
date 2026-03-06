<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');
            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');
        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-bold text-white uppercase tracking-widest border-b border-white/10 pb-2 mb-4">
            Actualizar Contraseña
        </h2>
        <p class="text-sm text-gray-400">
            Asegúrate de usar una contraseña larga y aleatoria para mantener tu cuenta segura.
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <label for="update_password_current_password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Contraseña Actual</label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="input w-full max-w-md bg-black/50 border-white/20 text-white focus:border-[#00f5ff] focus:ring-[#00f5ff] rounded-lg" autocomplete="current-password" />
            @error('current_password') <span class="text-[#ff0055] text-xs font-bold block mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nueva Contraseña</label>
            <input wire:model="password" id="update_password_password" name="password" type="password" class="input w-full max-w-md bg-black/50 border-white/20 text-white focus:border-[#00f5ff] focus:ring-[#00f5ff] rounded-lg" autocomplete="new-password" />
            @error('password') <span class="text-[#ff0055] text-xs font-bold block mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Confirmar Nueva Contraseña</label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="input w-full max-w-md bg-black/50 border-white/20 text-white focus:border-[#00f5ff] focus:ring-[#00f5ff] rounded-lg" autocomplete="new-password" />
            @error('password_confirmation') <span class="text-[#ff0055] text-xs font-bold block mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black rounded-full px-8 shadow-[0_0_15px_rgba(0,245,255,0.4)]">
                Guardar Contraseña
            </button>

            <x-action-message class="me-3 text-[#00ff66] text-sm font-bold bg-[#00ff66]/10 px-4 py-2 rounded-full border border-[#00ff66]/30" on="password-updated">
                Contraseña Actualizada.
            </x-action-message>
        </div>
    </form>
</section>
