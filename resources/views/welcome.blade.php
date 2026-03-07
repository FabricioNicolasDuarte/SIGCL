<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIGCL Pro') }} - Plataforma Educativa de Próxima Generación</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,700,900|jetbrains-mono:400,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #050814; color: white; overflow-x: hidden; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .text-glow-cyan { text-shadow: 0 0 15px rgba(0, 245, 255, 0.5); }
        .text-glow-pink { text-shadow: 0 0 15px rgba(255, 0, 85, 0.5); }
        .bg-grid-pattern { background-image: linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 40px 40px; }
    </style>
</head>
<body class="antialiased bg-grid-pattern relative">

    <div class="fixed inset-0 z-[-2]">
        <img src="{{ asset('images/fondo1.png') }}" alt="Fondo SIGCL" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-black/70"></div>
    </div>

    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#00f5ff]/20 rounded-full blur-[120px] pointer-events-none z-[-1]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-[#ff0055]/20 rounded-full blur-[120px] pointer-events-none z-[-1]"></div>

    <nav class="relative z-50 border-b border-white/10 bg-black/50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-6">
                <div class="relative flex items-center justify-center">
                    <div class="absolute inset-0 bg-[#00f7ff00] blur-[15px] opacity-30 rounded-full"></div>
                    <img src="{{ asset('images/Recurso2.png') }}" alt="SIGCL Logo" class="h-20 w-auto relative z-10 drop-shadow-[0_0_15px_rgba(0,245,255,0.5)]">
                </div>
                <span class="text-2xl font-black tracking-[0.2em] uppercase hidden sm:block">SIGCL <span class="text-[#00f5ff]">PRO</span></span>
            </div>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-[10px] font-bold text-white uppercase tracking-widest bg-[#00f5ff]/10 border border-[#00f5ff]/50 px-5 py-2.5 rounded-full hover:bg-[#00f5ff] hover:text-black transition-all shadow-[0_0_10px_rgba(0,245,255,0.2)]">Ir al Panel</a>
                @else
                    <a href="{{ route('login') }}" class="text-[10px] font-bold text-white uppercase tracking-widest bg-[#ff0055]/10 border border-[#ff0055]/50 px-5 py-2.5 rounded-full hover:bg-[#ff0055] hover:text-white transition-all shadow-[0_0_10px_rgba(255,0,85,0.2)]">Acceso al Sistema</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="relative z-10 max-w-7xl mx-auto px-6 pt-24 pb-32 text-center flex flex-col items-center justify-center min-h-[80vh]">
        <div class="inline-block mb-6 px-4 py-1.5 rounded-full border border-[#00ff66]/30 bg-[#00ff66]/5 backdrop-blur-sm">
            <p class="text-[9px] font-mono text-[#00ff66] uppercase tracking-[0.3em] flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00ff66] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#00ff66]"></span>
                </span>
                Sistema Online De Capacitaciones y Cursos
            </p>
        </div>

        <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tight leading-tight mb-6">
            La Educación, <br />
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00f5ff] to-[#0055ff] text-glow-cyan">Evolucionada.</span>
        </h1>

        <p class="text-gray-400 max-w-2xl mx-auto mb-12 text-sm md:text-base leading-relaxed backdrop-blur-sm bg-black/20 p-4 rounded-xl border border-white/5">
            Una plataforma integral diseñada para instituciones de alto rendimiento. Control biométrico de asistencia, aulas virtuales en tiempo real y un Tutor de Inteligencia Artificial disponible 24/7.
        </p>

        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            @auth
                <a href="{{ route('dashboard') }}" class="group relative px-8 py-4 bg-[#00f5ff] text-black font-black uppercase tracking-widest text-xs rounded-xl overflow-hidden shadow-[0_0_30px_rgba(0,245,255,0.4)] hover:shadow-[0_0_50px_rgba(0,245,255,0.6)] transition-all">
                    <span class="relative z-10 flex items-center gap-2">
                        Ingresar a tu Terminal
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </span>
                </a>
                <a href="#caracteristicas" class="px-8 py-4 bg-transparent border border-white/20 text-white font-black uppercase tracking-widest text-xs rounded-xl hover:bg-white/5 hover:border-white/50 backdrop-blur-sm transition-all">
                    Explorar Arquitectura
                </a>
            @else
                <a href="{{ route('login') }}" class="group relative px-8 py-4 bg-[#00f5ff] text-black font-black uppercase tracking-widest text-xs rounded-xl overflow-hidden shadow-[0_0_30px_rgba(0,245,255,0.4)] hover:shadow-[0_0_50px_rgba(0,245,255,0.6)] transition-all">
                    <span class="relative z-10 flex items-center gap-2">
                        Iniciar Sesión
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </span>
                </a>
                <a href="#caracteristicas" class="px-8 py-4 bg-transparent border border-white/20 text-white font-black uppercase tracking-widest text-xs rounded-xl hover:bg-white/5 hover:border-white/50 backdrop-blur-sm transition-all">
                    Explorar Arquitectura
                </a>
            @endauth
        </div>
    </main>

    <section id="caracteristicas" class="relative z-10 border-t border-white/10 bg-[#02040a]/90 backdrop-blur-xl py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-sm text-[#ff0055] font-black uppercase tracking-[0.3em] mb-3 text-glow-pink">Especificaciones Técnicas</h2>
                <h3 class="text-3xl font-black text-white uppercase tracking-widest">Tecnología de Vanguardia</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-black/40 border border-white/10 rounded-3xl p-8 hover:border-[#00f5ff]/50 hover:shadow-[0_0_30px_rgba(0,245,255,0.1)] transition-all group backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-xl bg-[#00f5ff]/10 flex items-center justify-center mb-6 text-[#00f5ff] group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                    </div>
                    <h4 class="text-lg font-black text-white uppercase tracking-wider mb-3">Pases QR Dinámicos</h4>
                    <p class="text-sm text-gray-400 leading-relaxed">Control de asistencia impenetrable. Los pases de abordaje caducan y se regeneran, asegurando la integridad del registro de cada alumno.</p>
                </div>

                <div class="bg-black/40 border border-white/10 rounded-3xl p-8 hover:border-[#ff0055]/50 hover:shadow-[0_0_30px_rgba(255,0,85,0.1)] transition-all group backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-xl bg-[#ff0055]/10 flex items-center justify-center mb-6 text-[#ff0055] group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <h4 class="text-lg font-black text-white uppercase tracking-wider mb-3">Tutor de IA Integrado</h4>
                    <p class="text-sm text-gray-400 leading-relaxed">Asistencia académica 24/7. Un motor de Inteligencia Artificial entrenado para resolver dudas de los estudiantes en tiempo real desde el panel.</p>
                </div>

                <div class="bg-black/40 border border-white/10 rounded-3xl p-8 hover:border-[#00ff66]/50 hover:shadow-[0_0_30px_rgba(0,255,102,0.1)] transition-all group backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-xl bg-[#00ff66]/10 flex items-center justify-center mb-6 text-[#00ff66] group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                    </div>
                    <h4 class="text-lg font-black text-white uppercase tracking-wider mb-3">Transmisión WebRTC</h4>
                    <p class="text-sm text-gray-400 leading-relaxed">Salas virtuales integradas directamente en el panel sin requerir software externo. Videoconferencias holográficas de alta definición.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="border-t border-white/10 py-10 text-center bg-black">
        <div class="max-w-4xl mx-auto px-6 flex flex-col items-center gap-4">
            <img src="{{ asset('images/Recurso2.png') }}" alt="SIGCL Logo Pequeño" class="h-8 w-auto opacity-50 grayscale hover:grayscale-0 transition-all">
            <div class="text-[10px] text-gray-500 font-mono uppercase tracking-[0.2em] leading-relaxed">
                <p class="text-gray-400 mb-1">
                    &copy; {{ date('Y') }} SIGCL PRO. Todos los derechos reservados.
                </p>
                <p>
                    El diseño, código fuente, logotipos y arquitectura de este software son propiedad intelectual exclusiva de <span class="text-[#00f5ff] font-bold">Skadia</span>. <br class="hidden sm:block" />
                    Queda estrictamente prohibida su reproducción, distribución o modificación sin autorización previa.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>
