<div class="p-4 sm:p-6">
    <div class="mb-6 sm:mb-8 border-b border-white/10 pb-4 sm:pb-6">
        <h1 class="text-xl sm:text-3xl font-black text-white uppercase tracking-wider flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
            <span>Terminal de Usuario</span>
            <span class="text-[#00f5ff] text-glow-cyan hidden sm:inline">|</span>
            <span class="text-[#00f5ff] text-glow-cyan sm:hidden"></span>
            <span class="text-[#00f5ff]">{{ auth()->user()->name }}</span>
        </h1>
        <p class="text-gray-400 mt-2 text-xs sm:text-sm font-mono uppercase">
            Rol de Sistema:
            <span class="text-[#ff0055] font-bold">
                {{ auth()->user()->roles->pluck('name')->implode(', ') ?: 'Sin Rol' }}
            </span>
        </p>
    </div>

    @role('admin')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-black/50 border border-[#00f5ff]/30 p-4 sm:p-6 rounded-2xl shadow-[0_0_15px_rgba(0,245,255,0.1)]">
                <h3 class="text-[10px] sm:text-xs font-mono text-gray-400 uppercase tracking-widest mb-1 sm:mb-2">Total Estudiantes</h3>
                <p class="text-3xl sm:text-4xl font-black text-[#00f5ff]">{{ $totalStudents }}</p>
            </div>

            <div class="bg-black/50 border border-[#ff0055]/30 p-4 sm:p-6 rounded-2xl shadow-[0_0_15px_rgba(255,0,85,0.1)]">
                <h3 class="text-[10px] sm:text-xs font-mono text-gray-400 uppercase tracking-widest mb-1 sm:mb-2">Total Docentes</h3>
                <p class="text-3xl sm:text-4xl font-black text-[#ff0055]">{{ $totalTeachers }}</p>
            </div>

            <div class="bg-black/50 border border-[#00ff66]/30 p-4 sm:p-6 rounded-2xl shadow-[0_0_15px_rgba(0,255,102,0.1)]">
                <h3 class="text-[10px] sm:text-xs font-mono text-gray-400 uppercase tracking-widest mb-1 sm:mb-2">Asistencias Hoy</h3>
                <p class="text-3xl sm:text-4xl font-black text-[#00ff66]">{{ $todayAttendances }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-8">
            <div class="bg-[#050814] border border-white/10 p-4 sm:p-6 rounded-2xl">
                <h3 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider mb-4 border-b border-white/10 pb-2">Métricas Globales</h3>
                <div class="space-y-3 font-mono text-xs sm:text-sm">
                    <div class="flex justify-between items-center bg-white/5 p-2 sm:p-3 rounded">
                        <span class="text-gray-400">Cursos Activos:</span>
                        <span class="text-white font-bold">{{ $activeCourses }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-white/5 p-2 sm:p-3 rounded">
                        <span class="text-gray-400">Sedes Operativas:</span>
                        <span class="text-white font-bold">{{ $totalCampuses }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-white/5 p-2 sm:p-3 rounded">
                        <span class="text-gray-400">Inscripciones Totales:</span>
                        <span class="text-white font-bold">{{ $totalEnrollments }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#050814] border border-white/10 p-4 sm:p-6 rounded-2xl">
                <h3 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider mb-4 border-b border-white/10 pb-2">Registro en Tiempo Real</h3>
                <ul class="space-y-2 font-mono text-[10px] sm:text-xs">
                    @forelse($recentAttendances as $attendance)
                        <li class="flex flex-col sm:flex-row justify-between sm:items-center bg-black p-2 sm:p-3 border-l-2 border-[#00f5ff] gap-1 sm:gap-0">
                            <span class="text-gray-300 truncate max-w-[200px]">{{ $attendance->enrollment->student->name }}</span>
                            <span class="text-[#00f5ff]">{{ $attendance->entry_time ?? 'Presente' }}</span>
                        </li>
                    @empty
                        <li class="text-gray-500 italic p-2">No hay registros recientes.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    @endrole

    @role('profesor')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="bg-black/50 border border-[#00f5ff]/30 p-6 sm:p-8 rounded-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 bg-[#00f5ff]/10 rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                <h3 class="text-[10px] sm:text-sm font-mono text-gray-400 uppercase tracking-widest mb-2">Tus Cursos Asignados</h3>
                <p class="text-4xl sm:text-5xl font-black text-white mb-6">{{ $myActiveCourses }}</p>

                <a href="{{ route('teacher.clases') }}" class="block text-center sm:inline-block w-full sm:w-auto px-6 py-3 bg-[#00f5ff] text-black font-bold uppercase tracking-wider text-xs rounded hover:bg-[#00c5cc] transition-colors shadow-[0_0_15px_rgba(0,245,255,0.4)]">
                    Gestionar Mis Clases &rarr;
                </a>
            </div>
        </div>
    @endrole

    @role('estudiante')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="bg-black/50 border border-[#ff0055]/30 p-6 sm:p-8 rounded-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 bg-[#ff0055]/10 rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                <h3 class="text-[10px] sm:text-sm font-mono text-gray-400 uppercase tracking-widest mb-2">Cursos Inscritos</h3>
                <p class="text-4xl sm:text-5xl font-black text-white mb-6">{{ $myActiveCourses }}</p>

                <a href="{{ route('student.cursos') }}" class="block text-center sm:inline-block w-full sm:w-auto px-6 py-3 bg-[#ff0055] text-white font-bold uppercase tracking-wider text-xs rounded hover:bg-[#cc0044] transition-colors shadow-[0_0_15px_rgba(255,0,85,0.4)]">
                    Ir a Mis Cursos &rarr;
                </a>
            </div>

            <div class="bg-black/50 border border-[#00ff66]/30 p-6 sm:p-8 rounded-2xl">
                <h3 class="text-[10px] sm:text-sm font-mono text-gray-400 uppercase tracking-widest mb-2">Total Asistencias</h3>
                <p class="text-4xl sm:text-5xl font-black text-[#00ff66]">{{ $myTotalAttendances }}</p>
                <p class="mt-4 text-[10px] sm:text-xs text-gray-500 font-mono">Presentismo registrado mediante código QR dinámico.</p>
            </div>
        </div>
    @endrole
</div>
