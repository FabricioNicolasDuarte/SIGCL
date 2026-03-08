<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="sigcl-neon">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIGCL Pro') }}</title>

    <meta name="theme-color" content="#050814">
    <link rel="apple-touch-icon" href="{{ asset('images/Recurso1.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans relative text-gray-200 bg-cover bg-center bg-fixed bg-no-repeat overflow-hidden" style="background-image: linear-gradient(to bottom, rgba(5, 8, 20, 0.85), rgba(0, 0, 0, 0.95)), url('{{ asset('images/fondo1.png') }}');">

    <div class="h-[100dvh] flex relative w-full overflow-hidden">

        <aside class="hidden md:flex flex-col w-72 bg-[#050814]/95 backdrop-blur-3xl border-r border-[#0a192f] shadow-2xl z-20 relative h-full">
            <div class="p-6 flex items-center justify-center border-b border-[#0a192f]">
                <a href="{{ route('dashboard') }}" class="block transition-transform duration-300 hover:scale-105">
                    <img src="{{ asset('images/Recurso1.png') }}" alt="SIGCL Pro" class="h-14 w-auto drop-shadow-[0_0_15px_rgba(0,245,255,0.3)]">
                </a>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto custom-scrollbar">
                <a href="{{ route('dashboard') }}" class="btn btn-ghost w-full justify-start gap-3 {{ request()->routeIs('dashboard') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white' }}">Dashboard</a>

                @hasanyrole('admin|super_admin')
                    <div class="mt-6 mb-2 px-4 text-[10px] font-bold tracking-wider text-[#0055ff] uppercase">Administración</div>
                    <a href="{{ route('admin.sedes') }}" class="btn btn-ghost w-full justify-start gap-3 {{ request()->routeIs('admin.sedes') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white' }}">Sedes</a>
                    <a href="{{ route('admin.cursos') }}" class="btn btn-ghost w-full justify-start gap-3 {{ request()->routeIs('admin.cursos') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white' }}">Cursos</a>
                    <a href="{{ route('admin.usuarios') }}" class="btn btn-ghost w-full justify-start gap-3 {{ request()->routeIs('admin.usuarios') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white' }}">Usuarios</a>
                    <a href="{{ route('admin.inscripciones') }}" class="btn btn-ghost w-full justify-start gap-3 {{ request()->routeIs('admin.inscripciones') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white' }}">Matriculaciones</a>
                    <a href="{{ route('admin.calificaciones') }}" class="btn btn-ghost w-full justify-start gap-3 {{ request()->routeIs('admin.calificaciones') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white' }}">Calificaciones</a>
                @endhasanyrole

                @role('profesor')
                    <div class="mt-6 mb-2 px-4 text-[10px] font-bold tracking-wider text-[#00ff66] uppercase">Docencia</div>
                    <a href="{{ route('teacher.clases') }}" class="btn btn-ghost w-full justify-start gap-3 {{ request()->routeIs('teacher.clases') ? 'bg-[#00ff66]/10 text-[#00ff66] border border-[#00ff66]/20' : 'text-gray-400 hover:text-white' }}">Mis Clases Activas</a>
                @endrole

                @role('estudiante')
                    <div class="mt-6 mb-2 px-4 text-[10px] font-bold tracking-wider text-[#00f5ff] uppercase">Estudiante</div>
                    <a href="{{ route('student.cursos') }}" class="btn btn-ghost w-full justify-start gap-3 {{ request()->routeIs('student.cursos') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white' }}">Mis Módulos</a>
                @endrole
            </nav>

            <div class="p-6 border-t border-[#0a192f]">
                <a href="{{ route('salir') }}" class="btn btn-sm btn-outline border-white/20 text-gray-400 hover:bg-[#ff0055] hover:text-white hover:border-transparent w-full">Cerrar Sesión</a>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-[100dvh] relative z-10 w-full overflow-hidden">

            <header class="bg-[#050814]/80 backdrop-blur-md border-b border-[#0a192f] p-3 sm:p-4 flex justify-between items-center shadow-xl">
                <div class="md:hidden flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/Recurso2.png') }}" alt="Logo" class="h-8 w-auto ml-2">
                    </a>
                </div>

                <div class="flex-1"></div>

                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="border border-[#ff0055]/30 rounded-full bg-[#ff0055]/10 flex items-center justify-center p-2 transition-all hover:bg-[#ff0055]/20">
                        <livewire:layout.notification-bell />
                    </div>

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar hover:shadow-[0_0_15px_rgba(0,245,255,0.4)] transition-all">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full border-2 border-[#00f5ff]/50 bg-black">
                                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="object-cover w-full h-full rounded-full" />
                            </div>
                        </div>
                        <ul tabindex="0" class="mt-4 z-50 p-2 shadow-[0_0_30px_rgba(0,245,255,0.15)] menu menu-sm dropdown-content bg-[#050814] border border-[#0a192f] rounded-2xl w-56">
                            <li class="px-4 py-2 border-b border-white/10 mb-2">
                                <span class="font-bold text-white block">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-[#00f5ff] uppercase">{{ Auth::user()->roles->first()->name ?? 'Invitado' }}</span>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('profile') }}" class="text-gray-300 hover:text-[#00ff66]">Mi Perfil y Foto</a>
                            </li>
                            <li>
                                <a href="{{ route('salir') }}" class="text-[#ff0055] hover:bg-[#ff0055]/10 font-bold">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6 md:p-10 pb-28 md:pb-10 custom-scrollbar">
                @if (isset($header))
                    <h1 class="text-xl sm:text-2xl font-black text-white uppercase tracking-widest border-l-4 border-[#00f5ff] pl-3 sm:pl-4 mb-6 sm:mb-8">{{ $header }}</h1>
                @endif
                {{ $slot }}
            </div>
        </main>

        <div x-data="{ menuOpen: false }" class="md:hidden fixed bottom-0 left-0 w-full z-50 pointer-events-none">

            <div x-show="menuOpen" x-transition.opacity class="fixed inset-0 bg-black/70 backdrop-blur-sm pointer-events-auto" @click="menuOpen = false"></div>

            <div x-show="menuOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-y-full opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-y-0 opacity-100"
                 x-transition:leave-end="translate-y-full opacity-0"
                 class="absolute bottom-24 left-4 right-4 bg-[#050814]/95 border border-[#00f5ff]/40 rounded-3xl p-5 shadow-[0_0_40px_rgba(0,245,255,0.3)] pointer-events-auto flex flex-col gap-2 max-h-[60dvh] overflow-y-auto custom-scrollbar">

                <h3 class="text-center text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 border-b border-white/10 pb-2">Menú Principal</h3>

                <a href="{{ route('dashboard') }}" class="btn bg-white/5 border-none text-white justify-start">Dashboard</a>

                @hasanyrole('admin|super_admin')
                    <a href="{{ route('admin.sedes') }}" class="btn bg-white/5 border-none text-[#00f5ff] justify-start">Sedes</a>
                    <a href="{{ route('admin.cursos') }}" class="btn bg-white/5 border-none text-[#00f5ff] justify-start">Cursos</a>
                    <a href="{{ route('admin.usuarios') }}" class="btn bg-white/5 border-none text-[#00f5ff] justify-start">Usuarios</a>
                    <a href="{{ route('admin.inscripciones') }}" class="btn bg-white/5 border-none text-[#00f5ff] justify-start">Matriculaciones</a>
                    <a href="{{ route('admin.calificaciones') }}" class="btn bg-white/5 border-none text-[#00f5ff] justify-start">Calificaciones</a>
                @endhasanyrole

                @role('profesor')
                    <a href="{{ route('teacher.clases') }}" class="btn bg-[#00ff66]/10 border-none text-[#00ff66] justify-start">Mis Clases Activas</a>
                @endrole

                @role('estudiante')
                    <a href="{{ route('student.cursos') }}" class="btn bg-[#00f5ff]/10 border-none text-[#00f5ff] justify-start">Mis Módulos</a>
                @endrole

                <a href="{{ route('salir') }}" class="btn bg-[#ff0055]/10 border-none text-[#ff0055] justify-start mt-2">Cerrar Sesión</a>
            </div>

            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 pointer-events-auto">
                <button @click="menuOpen = !menuOpen"
                        class="w-16 h-16 rounded-full flex items-center justify-center border-[3px] transition-all duration-300 shadow-[0_0_20px_rgba(0,245,255,0.4)] hover:scale-105"
                        :class="menuOpen ? 'bg-[#ff0055] border-[#ff0055] text-white shadow-[0_0_30px_rgba(255,0,85,0.5)]' : 'bg-[#050814] border-[#00f5ff] text-[#00f5ff]'">
                    <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    <svg x-show="menuOpen" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
