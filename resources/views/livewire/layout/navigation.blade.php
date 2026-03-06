<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-[#050814] border-b border-[#0a192f]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24 items-center">

            <div class="flex items-center">
                <div class="shrink-0 flex items-center mr-4">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo style="height: 85px; width: 85px;" class="block fill-current text-[#00f5ff] drop-shadow-[0_0_10px_rgba(0,245,255,0.5)]" />
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="text-gray-300 hover:text-white">
                        Dashboard
                    </x-nav-link>

                    <a href="{{ route('profile') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-[#00ff66]/10 border border-[#00ff66]/50 text-[#00ff66] font-bold rounded-full shadow-[0_0_15px_rgba(0,255,102,0.3)] hover:bg-[#00ff66] hover:text-black transition-all text-xs tracking-widest uppercase">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Mi Perfil / Avatar
                    </a>

                    <div class="ml-4 border border-[#ff0055]/30 rounded-full bg-[#ff0055]/10 flex items-center">
                        <livewire:layout.notification-bell />
                    </div>

                    @role('super_admin')
                        <x-nav-link :href="route('admin.sedes')" wire:navigate class="text-gray-300 hover:text-white">Nodos (Sedes)</x-nav-link>
                        <x-nav-link :href="route('admin.cursos')" wire:navigate class="text-gray-300 hover:text-white">Módulos</x-nav-link>
                        <x-nav-link :href="route('admin.usuarios')" wire:navigate class="text-gray-300 hover:text-white">Directorio</x-nav-link>
                        <x-nav-link :href="route('admin.inscripciones')" wire:navigate class="text-gray-300 hover:text-white">Matriculación</x-nav-link>
                        <x-nav-link :href="route('admin.calificaciones')" wire:navigate class="text-[#00f5ff] font-bold hover:text-white">Calificaciones</x-nav-link>
                    @endrole

                    @role('estudiante')
                        <x-nav-link :href="route('student.cursos')" wire:navigate class="text-[#00f5ff] font-bold hover:text-white">Mis Módulos</x-nav-link>
                    @endrole

                    @role('profesor')
                        <x-nav-link :href="route('teacher.clases')" wire:navigate class="text-[#00ff66] font-bold hover:text-white">Mis Clases</x-nav-link>
                    @endrole
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center pl-2 pr-3 py-1.5 border border-[#0a192f] text-sm leading-4 font-bold rounded-full text-gray-300 bg-black/50 hover:text-white focus:outline-none transition ease-in-out shadow-[0_0_10px_rgba(0,245,255,0.1)] group">

                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="h-8 w-8 rounded-full border border-[#00f5ff]/30 mr-2 group-hover:border-[#00f5ff] transition-all object-cover">

                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-[#00f5ff]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-white/10 text-center bg-black/50">
                            <p class="text-white font-bold text-sm">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</p>
                            <p class="text-[10px] text-[#00f5ff] font-mono mt-0.5 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link class="py-2 text-[#ff0055] hover:bg-[#ff0055]/10">Desconectar</x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden gap-4">
                <div class="border border-[#ff0055]/30 rounded-full bg-[#ff0055]/10 flex items-center">
                    <livewire:layout.notification-bell />
                </div>

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#050814] border-b border-[#0a192f]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" wire:navigate class="text-gray-300">Dashboard</x-responsive-nav-link>

            <x-responsive-nav-link :href="route('profile')" wire:navigate class="text-[#00ff66] font-bold">Mi Perfil / Avatar</x-responsive-nav-link>

            @role('super_admin')
                <x-responsive-nav-link :href="route('admin.sedes')" wire:navigate class="text-gray-300">Nodos (Sedes)</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.cursos')" wire:navigate class="text-gray-300">Módulos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.usuarios')" wire:navigate class="text-gray-300">Directorio</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.inscripciones')" wire:navigate class="text-gray-300">Matriculación</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.calificaciones')" wire:navigate class="text-[#00f5ff] font-bold">Calificaciones</x-responsive-nav-link>
            @endrole

            @role('estudiante')
                <x-responsive-nav-link :href="route('student.cursos')" wire:navigate class="text-[#00f5ff] font-bold">Mis Módulos</x-responsive-nav-link>
            @endrole

            @role('profesor')
                <x-responsive-nav-link :href="route('teacher.clases')" wire:navigate class="text-[#00ff66] font-bold">Mis Clases</x-responsive-nav-link>
            @endrole
        </div>

        <div class="pt-4 pb-1 border-t border-white/10 bg-black/40">
            <div class="px-4 flex items-center gap-3">
                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="h-10 w-10 rounded-full border border-[#00f5ff]/50 object-cover">
                <div>
                    <div class="font-bold text-base text-white">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-[11px] text-[#00f5ff] font-mono">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <div class="mt-4 space-y-1">
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="text-[#ff0055]">Desconectar</x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
