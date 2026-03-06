<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <x-auth-session-status class="mb-4 text-[#00ff66] text-xs font-bold bg-[#00ff66]/10 p-3 rounded-lg border border-[#00ff66]/30 text-center" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-3xl font-black text-white uppercase tracking-widest">Identificación</h2>
        <p class="text-[10px] text-[#00f5ff] font-mono tracking-widest uppercase mt-1">Terminal de Acceso Central</p>
    </div>

    <form wire:submit="login" class="space-y-6">
        <div>
            <label for="email" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#00f5ff]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                Correo Electrónico
            </label>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-700 focus:border-[#00f5ff] focus:ring-1 focus:ring-[#00f5ff] transition-all shadow-inner font-mono text-sm" placeholder="usuario@sigcl.edu" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-[#ff0055] text-[10px] font-bold uppercase tracking-wide" />
        </div>

        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#ff0055]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Clave de Seguridad
                </label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] text-gray-500 hover:text-[#00f5ff] transition-colors font-mono" href="{{ route('password.request') }}" wire:navigate>
                        ¿Olvidaste tu clave?
                    </a>
                @endif
            </div>
            <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-white placeholder-gray-700 focus:border-[#ff0055] focus:ring-1 focus:ring-[#ff0055] transition-all shadow-inner font-mono text-xl tracking-[0.2em]" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-[#ff0055] text-[10px] font-bold uppercase tracking-wide" />
        </div>

        <div class="flex items-center pt-2">
            <label class="cursor-pointer flex items-center gap-2 group">
                <input wire:model="form.remember" id="remember" type="checkbox" class="checkbox checkbox-sm border-gray-600 rounded checked:border-[#00ff66] checked:bg-[#00ff66]" name="remember" />
                <span class="text-xs text-gray-400 group-hover:text-white transition-colors">Mantener conexión activa</span>
            </label>
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full btn bg-transparent border border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black font-black uppercase tracking-widest rounded-xl py-3 shadow-[0_0_20px_rgba(0,245,255,0.3)] hover:shadow-[0_0_30px_rgba(0,245,255,0.6)] transition-all duration-300 flex justify-center items-center gap-3 group">
                Conectar a la Red
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
            </button>
        </div>
    </form>
</div>
