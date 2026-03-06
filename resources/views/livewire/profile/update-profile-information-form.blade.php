<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-bold text-white uppercase tracking-widest border-b border-white/10 pb-2 mb-4">
            Información del Perfil
        </h2>
        <p class="text-sm text-gray-400">
            Actualiza la información de tu cuenta y dirección de correo electrónico.
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <label for="name" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nombres</label>
            <input wire:model="name" id="name" name="name" type="text" class="input w-full max-w-md bg-black/50 border-white/20 text-white focus:border-[#00f5ff] focus:ring-[#00f5ff] rounded-lg" required autofocus autocomplete="name" />
            @error('name') <span class="text-[#ff0055] text-xs font-bold block mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Correo Electrónico</label>
            <input wire:model="email" id="email" name="email" type="email" class="input w-full max-w-md bg-black/50 border-white/20 text-white focus:border-[#00f5ff] focus:ring-[#00f5ff] rounded-lg" required autocomplete="username" />
            @error('email') <span class="text-[#ff0055] text-xs font-bold block mt-1">{{ $message }}</span> @enderror

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-400">
                        Tu dirección de correo no está verificada.
                        <button wire:click.prevent="sendVerification" class="underline text-[#00f5ff] hover:text-white rounded-md focus:outline-none">
                            Haz clic aquí para reenviar el correo de verificación.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-[#00ff66]">
                            Se ha enviado un nuevo enlace de verificación a tu correo.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black rounded-full px-8 shadow-[0_0_15px_rgba(0,245,255,0.4)]">
                Guardar Cambios
            </button>

            <x-action-message class="me-3 text-[#00ff66] text-sm font-bold bg-[#00ff66]/10 px-4 py-2 rounded-full border border-[#00ff66]/30" on="profile-updated">
                ¡Guardado Exitosamente!
            </x-action-message>
        </div>
    </form>
</section>
