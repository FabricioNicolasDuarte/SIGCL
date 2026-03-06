<div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @role('super_admin')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-6 relative overflow-hidden group border-t-2 border-t-[#00f5ff] hover:shadow-[0_0_25px_rgba(0,245,255,0.15)] transition-all duration-500">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#00f5ff]/10 rounded-full blur-xl group-hover:bg-[#00f5ff]/20 transition-all duration-500"></div>
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Alumnos Activos</p>
                        <h3 class="text-4xl font-black text-white mt-2">{{ $totalStudents }}</h3>
                    </div>
                    <div class="p-3 bg-[#00f5ff]/10 rounded-xl border border-[#00f5ff]/30 text-[#00f5ff]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-6 relative overflow-hidden group border-t-2 border-t-[#00ff66] hover:shadow-[0_0_25px_rgba(0,255,102,0.15)] transition-all duration-500">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#00ff66]/10 rounded-full blur-xl group-hover:bg-[#00ff66]/20 transition-all duration-500"></div>
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Docentes</p>
                        <h3 class="text-4xl font-black text-white mt-2">{{ $totalTeachers }}</h3>
                    </div>
                    <div class="p-3 bg-[#00ff66]/10 rounded-xl border border-[#00ff66]/30 text-[#00ff66]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-6 relative overflow-hidden group border-t-2 border-t-[#0055ff] hover:shadow-[0_0_25px_rgba(0,85,255,0.15)] transition-all duration-500">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#0055ff]/10 rounded-full blur-xl group-hover:bg-[#0055ff]/20 transition-all duration-500"></div>
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Módulos Abiertos</p>
                        <h3 class="text-4xl font-black text-white mt-2">{{ $activeCourses }}</h3>
                    </div>
                    <div class="p-3 bg-[#0055ff]/10 rounded-xl border border-[#0055ff]/30 text-[#0055ff]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-6 relative overflow-hidden group border-t-2 border-t-[#ff0055] hover:shadow-[0_0_25px_rgba(255,0,85,0.15)] transition-all duration-500">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#ff0055]/10 rounded-full blur-xl group-hover:bg-[#ff0055]/20 transition-all duration-500"></div>
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-[10px] font-bold text-[#ff0055] uppercase tracking-widest">Escaneos de Hoy</p>
                        <h3 class="text-4xl font-black text-[#ff0055] mt-2" style="text-shadow: 0 0 15px rgba(255,0,85,0.4);">{{ $todayAttendances }}</h3>
                    </div>
                    <div class="p-3 bg-[#ff0055]/10 rounded-xl border border-[#ff0055]/30 text-[#ff0055]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-[#050814] border border-[#0a192f] shadow-2xl rounded-2xl p-6 relative">
                <h2 class="text-xs font-bold text-white uppercase tracking-widest flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#00f5ff]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                    Tendencia de Asistencias (Últimos 7 Días)
                </h2>
                <div class="relative h-64 w-full">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <div class="bg-[#050814] border border-[#0a192f] shadow-2xl rounded-2xl p-6 relative">
                <h2 class="text-xs font-bold text-white uppercase tracking-widest flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#00ff66]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Densidad de Alumnos por Módulo (Top 5)
                </h2>
                <div class="relative h-64 w-full">
                    <canvas id="coursesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-[#050814] border border-[#0a192f] shadow-2xl rounded-2xl p-6 relative">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xs font-bold text-white uppercase tracking-widest flex items-center gap-2">
                        Radar Biométrico en Vivo
                    </h2>
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00ff66] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#00ff66]"></span>
                    </span>
                </div>
                <div class="space-y-3 custom-scrollbar overflow-y-auto max-h-[220px] pr-2">
                    @forelse($recentAttendances as $att)
                        <div class="bg-black/40 border border-[#00ff66]/20 p-3 rounded-xl flex justify-between items-center group hover:border-[#00ff66]/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <img src="{{ $att->enrollment->student->avatar_url }}" class="w-8 h-8 rounded-full border border-white/10" alt="">
                                <div>
                                    <p class="text-white font-bold text-sm">{{ $att->enrollment->student->name }}</p>
                                    <p class="text-[#00ff66] text-[10px] font-mono mt-0.5">{{ $att->enrollment->training->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-gray-500 block mb-1 font-mono">{{ $att->entry_time }}</span>
                                <span class="text-[9px] bg-[#00ff66]/10 text-[#00ff66] px-2 py-0.5 rounded border border-[#00ff66]/30 uppercase font-bold">Verificado</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-xs italic text-center p-4">Sin lecturas recientes.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-[#050814] border border-[#0a192f] shadow-2xl rounded-2xl p-6 relative">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xs font-bold text-white uppercase tracking-widest flex items-center gap-2">
                        Últimas Matriculaciones
                    </h2>
                </div>
                <div class="space-y-3 custom-scrollbar overflow-y-auto max-h-[220px] pr-2">
                    @forelse($recentEnrollments as $enr)
                        <div class="bg-black/40 border border-[#0055ff]/20 p-3 rounded-xl flex justify-between items-center group hover:border-[#0055ff]/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <img src="{{ $enr->student->avatar_url }}" class="w-8 h-8 rounded-full border border-white/10" alt="">
                                <div>
                                    <p class="text-white font-bold text-sm">{{ $enr->student->name }}</p>
                                    <p class="text-[#00f5ff] text-[10px] font-mono mt-0.5">{{ $enr->training->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-gray-500 block mb-1 font-mono">ID: #{{ $enr->id }}</span>
                                <span class="text-[9px] bg-[#0055ff]/10 text-[#00f5ff] px-2 py-0.5 rounded border border-[#0055ff]/30 uppercase font-bold">Activo</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-xs italic text-center p-4">Sin enlaces recientes.</p>
                    @endforelse
                </div>
            </div>
        </div>

        @script
        <script>
            Chart.defaults.color = '#6b7280';
            Chart.defaults.font.family = 'Outfit, sans-serif';

            // GRÁFICO 1: TENDENCIA (LÍNEA)
            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: @json($trendLabels),
                    datasets: [{
                        label: 'Asistencias',
                        data: @json($trendData),
                        borderColor: '#00f5ff',
                        backgroundColor: 'rgba(0, 245, 255, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#050814',
                        pointBorderColor: '#00f5ff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } },
                        x: { grid: { color: 'rgba(255,255,255,0.05)' } }
                    }
                }
            });

            // GRÁFICO 2: CURSOS (BARRAS)
            new Chart(document.getElementById('coursesChart'), {
                type: 'bar',
                data: {
                    labels: @json($courseLabels),
                    datasets: [{
                        label: 'Alumnos',
                        data: @json($courseData),
                        backgroundColor: [
                            'rgba(0, 255, 102, 0.2)',
                            'rgba(0, 245, 255, 0.2)',
                            'rgba(255, 0, 85, 0.2)',
                            'rgba(0, 85, 255, 0.2)',
                            'rgba(255, 255, 255, 0.1)'
                        ],
                        borderColor: [
                            '#00ff66', '#00f5ff', '#ff0055', '#0055ff', '#ffffff'
                        ],
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        </script>
        @endscript
    @endrole

    @role('estudiante|profesor')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-6 relative overflow-hidden group border-t-2 border-t-[#00f5ff]">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Módulos Asignados</p>
                <h3 class="text-4xl font-black text-white mt-2">{{ $myActiveCourses }}</h3>
            </div>

            @role('estudiante')
            <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-6 relative overflow-hidden group border-t-2 border-t-[#00ff66]">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Mis Asistencias Históricas</p>
                <h3 class="text-4xl font-black text-[#00ff66] mt-2">{{ $myTotalAttendances }}</h3>
            </div>
            @endrole
        </div>

        <div class="bg-gradient-to-r from-[#050814] to-[#0a192f] border border-[#00f5ff]/30 rounded-2xl border-l-4 border-l-[#00f5ff] p-10 relative overflow-hidden shadow-[0_0_30px_rgba(0,245,255,0.1)]">
            <div class="absolute right-0 top-0 w-1/2 h-full opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="h-32 w-32 rounded-full border-4 border-[#00f5ff]/50 shadow-[0_0_20px_rgba(0,245,255,0.4)] object-cover">
                <div>
                    <p class="text-[#00f5ff] font-mono text-xs uppercase tracking-widest mb-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#00f5ff] animate-ping"></span>
                        Identidad Verificada
                    </p>
                    <h1 class="text-4xl md:text-5xl font-black text-white mb-2">Bienvenido, <span class="text-[#00f5ff]">{{ auth()->user()->name }}</span></h1>
                    <p class="text-gray-400 max-w-xl mb-6">Tu perfil ha sido enlazado a la red central. Accede a tu módulo para ver tus asistencias, generar tu Pase de Abordaje y consultar tu libro de calificaciones.</p>

                    <a href="{{ auth()->user()->hasRole('estudiante') ? route('student.cursos') : route('teacher.clases') }}"
                       class="inline-flex items-center gap-2 bg-[#00f5ff]/10 border border-[#00f5ff]/50 text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-full transition-all shadow-[0_0_15px_rgba(0,245,255,0.2)]">
                        Abrir Terminal de Control
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </a>
                </div>
            </div>
        </div>
    @endrole
</div>
