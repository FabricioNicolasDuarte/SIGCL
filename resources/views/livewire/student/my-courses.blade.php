<div class="grid grid-cols-1 xl:grid-cols-3 gap-10 relative antialiased">

    <div class="xl:col-span-2 space-y-8">
        <h2 class="text-xs font-black text-gray-500 tracking-[0.3em] uppercase mb-6 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#00f5ff]/70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            Hoja de Ruta Académica
        </h2>

        @foreach($enrollments as $enrollment)
            <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-7 relative overflow-hidden shadow-2xl mb-8 group transition-all duration-500 hover:border-[#00f5ff]/20 hover:shadow-[0_0_50px_rgba(0,245,255,0.05)]">

                <div class="border-b border-white/5 pb-5 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div>
                        <h2 class="text-3xl font-black text-white leading-tight tracking-tight">{{ $enrollment->training->name }}</h2>
                        <p class="text-[10px] text-gray-500 mt-1.5 font-mono uppercase tracking-widest">
                            <span class="text-[#00f5ff] opacity-70">●</span> Mentor: {{ $enrollment->training->teacher->name ?? 'IA' }} {{ $enrollment->training->teacher->last_name ?? '' }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-6 md:gap-4">
                        <a href="{{ route('virtual.room', $enrollment->training->id) }}" wire:navigate class="group/btn flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-[#ff0055] hover:text-[#ff0055] transition-all duration-300 relative py-1">
                            <span class="relative flex h-2 w-2 mr-1">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#ff0055] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#ff0055]"></span>
                            </span>
                            Clase en Vivo
                            <span class="absolute bottom-0 left-0 w-0 h-[1px] bg-[#ff0055] shadow-[0_0_10px_#ff0055] transition-all duration-300 group-hover/btn:w-full"></span>
                        </a>

                        <a href="{{ route('student.certificate', $enrollment->training->id) }}" target="_blank" class="group/btn flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-gray-300 hover:text-[#00ff66] transition-all duration-300 relative py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover/btn:scale-110 text-[#00ff66]/70 group-hover/btn:text-[#00ff66]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Mi Analítico
                            <span class="absolute bottom-0 left-0 w-0 h-[1px] bg-[#00ff66] shadow-[0_0_10px_#00ff66] transition-all duration-300 group-hover/btn:w-full"></span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                    <div>
                        <h3 class="text-[#00ff66] text-[10px] font-black uppercase tracking-[0.3em] pb-3 mb-4 flex items-center gap-2.5">
                            Cronograma de Asistencias
                        </h3>
                        <div class="space-y-2.5 max-h-60 overflow-y-auto custom-scrollbar pr-3">
                            @forelse($enrollment->training->courseClasses as $class)
                                @php
                                    $att = $enrollment->attendances->where('course_class_id', $class->id)->first();
                                    $isToday = \Carbon\Carbon::parse($class->date)->isToday();
                                @endphp
                                <div class="flex justify-between items-center p-3 rounded-lg transition-colors {{ $isToday ? 'bg-[#00f5ff]/5' : 'bg-white/[0.02]' }}">
                                    <div>
                                        <p class="text-white text-xs font-bold">{{ $class->name }}</p>
                                        <p class="text-[9px] text-gray-600 font-mono tracking-wider">{{ \Carbon\Carbon::parse($class->date)->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        @if($att)
                                            <span class="text-[8px] font-black uppercase tracking-[0.2em] text-[#00ff66] bg-[#00ff66]/5 px-2 py-0.5 rounded border border-[#00ff66]/20">Presente</span>
                                        @else
                                            <button wire:click="generateQR({{ $class->id }}, '{{ addslashes($class->name) }}')" class="group/qr flex items-center gap-1.5 text-[9px] font-black uppercase tracking-[0.2em] text-[#00f5ff]/70 hover:text-[#00f5ff] transition-all duration-300 relative py-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transition-transform group-hover/qr:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                                Pase QR
                                                <span class="absolute bottom-0 left-0 w-0 h-[1px] bg-[#00f5ff] shadow-[0_0_8px_#00f5ff] transition-all duration-300 group-hover/qr:w-full"></span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-[10px] text-gray-600 italic tracking-wide">No hay clases programadas aún.</p>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h3 class="text-[#0055ff] text-[10px] font-black uppercase tracking-[0.3em] pb-3 mb-4 flex items-center gap-2.5">
                            Evaluaciones (Promedios)
                        </h3>
                        <div class="space-y-2.5">
                            @forelse($enrollment->training->evaluations as $eval)
                                @php
                                    $grade = $enrollment->grades->where('evaluation_id', $eval->id)->first();
                                @endphp
                                <div class="flex justify-between items-center p-3 rounded-lg bg-white/[0.02]">
                                    <div>
                                        <p class="text-white text-xs font-bold">{{ $eval->name }}</p>
                                        <p class="text-[9px] text-gray-600 font-mono tracking-wider">Máx: {{ $eval->max_score }}</p>
                                    </div>
                                    <div class="text-right">
                                        @if($grade)
                                            <span class="text-xl font-black {{ $grade->score >= ($eval->max_score * 0.6) ? 'text-[#00ff66]' : 'text-[#ff0055]' }}">{{ $grade->score }}</span>
                                        @else
                                            <span class="text-[8px] font-black uppercase tracking-[0.2em] text-gray-600 bg-black/30 px-2 py-0.5 rounded">A evaluar</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-[10px] text-gray-600 italic tracking-wide">No hay evaluaciones programadas.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="space-y-8">
        <div class="bg-[#050814] border border-[#0a192f] rounded-3xl p-7 relative overflow-hidden shadow-2xl flex flex-col h-[calc(100vh-140px)] min-h-[550px]">
            <h3 class="text-xs font-black text-white uppercase tracking-[0.3em] mb-5 pb-3 border-b border-white/5">Tutor IA</h3>
            <div class="flex-1 overflow-y-auto pr-3 space-y-4 mb-5 custom-scrollbar">
                @foreach($chatHistory as $chat)
                    <div class="flex {{ $chat['sender'] == 'ai' ? 'justify-start' : 'justify-end' }}">
                        <div class="bg-white/[0.03] border {{ $chat['sender'] == 'ai' ? 'border-white/5' : 'border-[#0055ff]/20' }} rounded-2xl p-4 max-w-[85%]">
                            <p class="text-xs leading-relaxed {{ $chat['sender'] == 'ai' ? 'text-gray-300' : 'text-[#00f5ff]' }}">{{ $chat['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <form wire:submit.prevent="askAI" class="mt-auto relative">
                <input type="text" wire:model="aiQuery" class="w-full bg-black/60 border border-white/5 rounded-full py-3.5 pl-6 pr-14 text-sm text-white placeholder-gray-700 focus:outline-none focus:border-[#0055ff]/50 focus:ring-1 focus:ring-[#0055ff]/30 transition-all shadow-inner" placeholder="Consulta a la Inteligencia Artificial...">
            </form>
        </div>
    </div>

    @if($showQr)
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-xl animate-[fade-in_0.3s_ease-out]" wire:click.self="closeQR">
            <div class="bg-[#050814] border border-[#00f5ff]/30 rounded-3xl w-full max-w-sm p-10 text-center shadow-[0_0_70px_rgba(0,245,255,0.15)] relative overflow-hidden">

                <div class="absolute -top-20 -right-20 w-40 h-40 bg-[#00f5ff]/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-[#ff0055]/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <h3 class="font-black text-sm text-white uppercase tracking-[0.3em] mb-1.5">Pase de Abordaje</h3>
                    <p class="text-[#00f5ff] text-[10px] font-black uppercase tracking-[0.1em] mb-9 drop-shadow-[0_0_8px_rgba(0,245,255,0.8)]">{{ $activeCourseName }}</p>

                    <div class="p-4 bg-white rounded-2xl inline-block mx-auto mb-10 relative group shadow-[0_0_30px_rgba(255,255,255,0.1)] transition-transform duration-500 hover:scale-105">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $qrToken }}&color=050814&bgcolor=ffffff" alt="QR" class="w-44 h-44 rounded-lg">
                    </div>

                    <button wire:click="closeQR" class="w-full group flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-[#ff0055] hover:text-[#ff0055] transition-all duration-300 relative py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        Destruir Pase QR
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-[1px] bg-[#ff0055] shadow-[0_0_10px_#ff0055] transition-all duration-300 group-hover:w-1/2"></span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0,245,255,0.1); }
        .antialiased { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
    </style>
</div>
