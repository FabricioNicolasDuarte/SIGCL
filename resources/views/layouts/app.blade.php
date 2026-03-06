<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="sigcl-neon">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIGCL Pro') }}</title>

    <link rel="manifest" href="{{ asset('manifest.json') }}">
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
<body class="font-sans relative text-gray-200 min-h-screen bg-cover bg-center bg-fixed bg-no-repeat" style="background-image: linear-gradient(to bottom, rgba(5, 8, 20, 0.85), rgba(0, 0, 0, 0.95)), url('{{ asset('images/fondo1.png') }}');">

    <div class="min-h-screen flex flex-col md:flex-row relative">

        <aside class="w-full md:w-72 bg-[#050814]/90 backdrop-blur-2xl hidden md:flex flex-col border-r border-[#0a192f] shadow-2xl z-40">
            <div class="p-6 flex items-center justify-center border-b border-[#0a192f]">
                <a href="{{ route('dashboard') }}" class="block transition-transform duration-300 hover:scale-105">
                    <img src="{{ asset('images/Recurso1.png') }}" alt="SIGCL Pro Logo" class="h-14 w-auto drop-shadow-[0_0_15px_rgba(0,245,255,0.3)]">
                </a>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="btn btn-ghost w-full justify-start gap-3 whitespace-nowrap {{ request()->routeIs('dashboard') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white hover:bg-[#0a192f]' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Dashboard
                </a>

                @role('super_admin')
                    <div class="mt-6 mb-2 px-4 text-xs font-bold tracking-wider text-[#0055ff] uppercase">Gestión Administrativa</div>
                    <a href="{{ route('admin.sedes') }}" class="btn btn-ghost w-full justify-start gap-3 whitespace-nowrap {{ request()->routeIs('admin.sedes') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white hover:bg-[#0a192f]' }}">Sedes</a>
                    <a href="{{ route('admin.cursos') }}" class="btn btn-ghost w-full justify-start gap-3 whitespace-nowrap {{ request()->routeIs('admin.cursos') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white hover:bg-[#0a192f]' }}">Cursos</a>
                    <a href="{{ route('admin.usuarios') }}" class="btn btn-ghost w-full justify-start gap-3 whitespace-nowrap {{ request()->routeIs('admin.usuarios') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white hover:bg-[#0a192f]' }}">Usuarios</a>
                    <a href="{{ route('admin.inscripciones') }}" class="btn btn-ghost w-full justify-start gap-3 whitespace-nowrap {{ request()->routeIs('admin.inscripciones') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white hover:bg-[#0a192f]' }}">Matriculaciones</a>
                    <a href="{{ route('admin.calificaciones') }}" class="btn btn-ghost w-full justify-start gap-3 whitespace-nowrap {{ request()->routeIs('admin.calificaciones') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white hover:bg-[#0a192f]' }}">Calificaciones</a>
                @endrole

                @role('profesor')
                    <div class="mt-6 mb-2 px-4 text-xs font-bold tracking-wider text-[#00ff66] uppercase">Panel Docente</div>
                    <a href="{{ route('teacher.clases') }}" class="btn btn-ghost w-full justify-start gap-3 whitespace-nowrap {{ request()->routeIs('teacher.clases') ? 'bg-[#00ff66]/10 text-[#00ff66] border border-[#00ff66]/20' : 'text-gray-400 hover:text-white hover:bg-[#0a192f]' }}">Mis Clases Activas</a>
                @endrole

                @role('estudiante')
                    <div class="mt-6 mb-2 px-4 text-xs font-bold tracking-wider text-[#00f5ff] uppercase">Panel Estudiante</div>
                    <a href="{{ route('student.cursos') }}" class="btn btn-ghost w-full justify-start gap-3 whitespace-nowrap {{ request()->routeIs('student.cursos') ? 'bg-[#00f5ff]/10 text-[#00f5ff] border border-[#00f5ff]/20' : 'text-gray-400 hover:text-white hover:bg-[#0a192f]' }}">Mis Módulos</a>
                @endrole
            </nav>

            <div class="p-6 border-t border-[#0a192f]">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline border-white/20 text-gray-400 hover:bg-white/5 hover:text-white hover:border-white/50 w-full whitespace-nowrap">Cerrar Sesión</button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden relative">

            <header class="bg-[#050814]/80 backdrop-blur-md border-b border-[#0a192f] z-10 p-4 flex justify-between items-center md:justify-end shadow-xl">

                <div class="md:hidden flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/Recurso1.png') }}" alt="SIGCL Pro Logo" class="h-8 w-auto drop-shadow-[0_0_10px_rgba(0,245,255,0.3)]">
                    </a>
                </div>

                <div class="flex items-center gap-4">

                    <div class="border border-[#ff0055]/30 rounded-full bg-[#ff0055]/10 flex items-center justify-center p-1 transition-all hover:bg-[#ff0055]/20 shadow-[0_0_15px_rgba(255,0,85,0.2)]">
                        <livewire:layout.notification-bell />
                    </div>

                    <div class="text-right hidden md:block border-r border-white/10 pr-4 mr-1">
                        <div class="text-sm font-semibold text-white">{{ Auth::user()->name ?? 'Usuario' }} {{ Auth::user()->last_name ?? '' }}</div>
                        <div class="text-[10px] text-[#00f5ff] font-medium tracking-wide uppercase">{{ Auth::user()->roles->first()->name ?? 'Invitado' }}</div>
                    </div>

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar hover:shadow-[0_0_15px_rgba(0,245,255,0.4)] transition-all">
                            <div class="w-10 rounded-full border-2 border-[#00f5ff]/50 bg-black">
                                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="object-cover w-full h-full" />
                            </div>
                        </div>
                        <ul tabindex="0" class="mt-4 z-50 p-2 shadow-[0_0_30px_rgba(0,245,255,0.15)] menu menu-sm dropdown-content bg-[#050814] border border-[#0a192f] rounded-2xl w-56">
                            <li class="mb-2">
                                <a href="{{ route('profile') }}" class="text-gray-300 font-bold hover:text-[#00ff66] hover:bg-white/5 py-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Mi Perfil y Foto
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="w-full m-0 p-0">
                                    @csrf
                                    <button type="submit" class="w-full text-left text-[#ff0055] font-bold hover:bg-[#ff0055]/10 px-4 py-3 rounded-xl transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-6 md:p-10 relative">
                @if (isset($header))
                    <h1 class="text-2xl font-black text-white uppercase tracking-widest border-l-4 border-[#00f5ff] pl-4 mb-8">{{ $header }}</h1>
                @endif
                {{ $slot }}
            </div>
        </main>
    </div>
    @livewireScripts

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then(registration => {
                    console.log('PWA Lista - ServiceWorker registrado: ', registration.scope);
                }).catch(err => {
                    console.log('Error al registrar PWA: ', err);
                });
            });
        }
    </script>
</body>
</html>
