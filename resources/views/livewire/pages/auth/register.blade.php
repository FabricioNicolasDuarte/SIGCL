<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        // Por defecto, Laravel Breeze asigna el rol básico o simplemente loguea al usuario.
        // Si usas Spatie Permissions y quieres darle un rol automático, lo harías aquí:
        // $user->assignRole('estudiante');

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-black text-white uppercase tracking-widest">Nueva Identidad</h2>
        <p class="text-[10px] text-[#00ff66] font-mono tracking-widest uppercase mt-1">Alta en la Red SIGCL</p>
    </div>

    <form wire:submit="register" class="space-y-6">
        <div>
            <label for="name" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#00ff66]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Nombre Completo
            </label>
            <input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-700 focus:border-[#00ff66] focus:ring-1 focus:ring-[#00ff66] transition-all shadow-inner font-mono text-sm" placeholder="Ej: Fabricio Duarte" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-[#ff0055] text-[10px] font-bold uppercase tracking-wide" />
        </div>

        <div>
            <label for="email" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#00f5ff]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                Correo Electrónico
            </label>
            <input wire:model="email" id="email" type="email" name="email" required autocomplete="username" class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-700 focus:border-[#00f5ff] focus:ring-1 focus:ring-[#00f5ff] transition-all shadow-inner font-mono text-sm" placeholder="usuario@sigcl.edu.ar" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[#ff0055] text-[10px] font-bold uppercase tracking-wide" />
        </div>

        <div>
            <label for="password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#ff0055]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                Clave de Seguridad
            </label>
            <input wire:model="password" id="password" type="password" name="password" required autocomplete="new-password" class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-700 focus:border-[#ff0055] focus:ring-1 focus:ring-[#ff0055] transition-all shadow-inner font-mono text-xl tracking-[0.2em]" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[#ff0055] text-[10px] font-bold uppercase tracking-wide" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#ff0055]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                Confirmar Clave
            </label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-700 focus:border-[#ff0055] focus:ring-1 focus:ring-[#ff0055] transition-all shadow-inner font-mono text-xl tracking-[0.2em]" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[#ff0055] text-[10px] font-bold uppercase tracking-wide" />
        </div>

        <div class="mt-8 flex flex-col-reverse sm:flex-row items-center justify-between gap-4 border-t border-white/10 pt-6">
            <a class="text-[10px] text-gray-500 hover:text-[#00ff66] transition-colors font-mono uppercase tracking-widest" href="{{ route('login') }}" wire:navigate>
                ¿Ya tienes una identidad?
            </a>

            <button type="submit" class="w-full sm:w-auto btn bg-[#00ff66]/10 border border-[#00ff66]/50 text-[#00ff66] hover:bg-[#00ff66] hover:text-black font-black uppercase tracking-widest rounded-xl py-3 px-8 shadow-[0_0_15px_rgba(0,255,102,0.2)] hover:shadow-[0_0_25px_rgba(0,255,102,0.5)] transition-all duration-300 flex justify-center items-center gap-2 group">
                Crear Perfil
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:rotate-90 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            </button>
        </div>
    </form>
</div>
