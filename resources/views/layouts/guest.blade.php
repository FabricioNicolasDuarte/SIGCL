<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="sigcl-neon">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIGCL Pro') }} - Portal de Acceso</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-200 antialiased min-h-screen bg-cover bg-center bg-no-repeat flex flex-col justify-center items-center relative" style="background-image: linear-gradient(to bottom, rgba(5, 8, 20, 0.7), rgba(0, 0, 0, 0.95)), url('{{ asset('images/fondo1.png') }}');">

    <div class="absolute inset-0 z-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>

    <div class="w-full sm:max-w-md px-8 py-10 bg-[#050814]/80 backdrop-blur-2xl border border-[#00f5ff]/30 shadow-[0_0_50px_rgba(0,245,255,0.15)] overflow-hidden sm:rounded-3xl relative z-10">

        <div class="absolute -top-20 -right-20 w-40 h-40 bg-[#00f5ff]/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-[#ff0055]/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex justify-center mb-8 relative z-10">
            <a href="/" wire:navigate class="transition-transform duration-500 hover:scale-110">
                <img src="{{ asset('images/Recurso1.png') }}" alt="SIGCL Pro" class="h-24 w-auto drop-shadow-[0_0_20px_rgba(0,245,255,0.5)]">
            </a>
        </div>

        <div class="relative z-10">
            {{ $slot }}
        </div>
    </div>

    <div class="absolute bottom-4 text-center w-full z-10">
        <p class="text-[10px] font-mono text-gray-500 uppercase tracking-widest">SIGCL Pro V.2.0 &copy; {{ date('Y') }} - Red Segura</p>
    </div>
</body>
</html>
