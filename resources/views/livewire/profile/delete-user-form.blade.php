<?php
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-[#ff0055] uppercase tracking-widest border-b border-[#ff0055]/20 pb-2 mb-4">
            Eliminar Cuenta
        </h2>
        <p class="text-sm text-gray-400">
            Una vez que se elimine tu cuenta, todos sus recursos y datos se borrarán permanentemente. Antes de eliminarla, descarga cualquier información que desees conservar.
        </p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="btn bg-[#ff0055]/10 border border-[#ff0055]/50 text-[#ff0055] hover:bg-[#ff0055] hover:text-white hover:border-[#ff0055] rounded-full px-8 shadow-[0_0_15px_rgba(255,0,85,0.4)] transition-all">
        Eliminar Cuenta Definitivamente
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-8 bg-[#050814] border border-[#ff0055]/50 rounded-2xl shadow-[0_0_40px_rgba(255,0,85,0.2)]">
            <h2 class="text-xl font-black text-white uppercase tracking-widest mb-4 border-b border-white/10 pb-4">
                ¿Estás seguro de eliminar tu cuenta?
            </h2>

            <p class="text-sm text-gray-400 mb-6">
                Esta acción es irreversible. Por favor, ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de la red permanentemente.
            </p>

            <div>
                <label for="password" class="block text-[10px] font-bold text-[#ff0055] uppercase tracking-widest mb-2">Contraseña de Confirmación</label>
                <input wire:model="password" id="password" name="password" type="password" class="input w-full bg-black/50 border-white/20 text-white focus:border-[#ff0055] focus:ring-[#ff0055] rounded-lg" placeholder="Ingresa tu contraseña" />
                @error('password') <span class="text-[#ff0055] text-xs font-bold block mt-2">{{ $message }}</span> @enderror
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-white/10 pt-4">
                <button type="button" x-on:click="$dispatch('close')" class="btn btn-outline border-gray-600 text-gray-400 hover:bg-gray-800 hover:text-white rounded-full">
                    Cancelar
                </button>

                <button type="submit" class="btn bg-[#ff0055] text-white border-none hover:bg-[#cc0044] rounded-full shadow-[0_0_15px_rgba(255,0,85,0.4)]">
                    Eliminar Perfil
                </button>
            </div>
        </form>
    </x-modal>
</section>
