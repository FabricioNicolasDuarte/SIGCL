<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-10 relative antialiased">

    <div class="xl:col-span-2 space-y-6 sm:space-y-8">
        <h2 class="text-[10px] sm:text-xs font-black text-gray-500 tracking-[0.2em] sm:tracking-[0.3em] uppercase mb-4 sm:mb-6 flex items-center gap-2 sm:gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#00f5ff]/70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            Hoja de Ruta Académica
        </h2>

        @foreach($enrollments as $enrollment)
            <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-5 sm:p-7 relative overflow-hidden shadow-2xl mb-6 sm:mb-8 group transition-all duration-500 hover:border-[#00f5ff]/20">

                <div class="border-b border-white/5 pb-4 sm:pb-5 mb-5 sm:mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 sm:gap-5">
                    <div>
                        <h2 class="text-xl sm:text-3xl font-black text-white leading-tight tracking-tight">{{ $enrollment->training->name }}</h2>
                        <p class="text-[9px] sm:text-[10px] text-gray-500 mt-1.5 font-mono uppercase tracking-widest">
                            <span class="text-[#00f5ff] opacity-70">●</span> Mentor: {{ $enrollment->training->teacher->name ?? 'IA' }} {{ $enrollment->training->teacher->last_name ?? '' }}
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 w-full md:w-auto">
                        <a href="{{ route('virtual.room', $enrollment->training->id) }}" wire:navigate class="w-full sm:w-auto justify-center bg-[#ff0055]/10 border border-[#ff0055]/30 sm:bg-transparent sm:border-transparent rounded-lg sm:rounded-none group/btn flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-[#ff0055] hover:text-[#ff0055] transition-all duration-300 relative py-3 sm:py-1">
                            <span class="relative flex h-2 w-2 mr-1">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#ff0055] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#ff0055]"></span>
                            </span>
                            Clase en Vivo
                            <span class="hidden sm:block absolute bottom-0 left-0 w-0 h-[1px] bg-[#ff0055] shadow-[0_0_10px_#ff0055] transition-all duration-300 group-hover/btn:w-full"></span>
                        </a>

                        <a href="{{ route('student.certificate', $enrollment->training->id) }}" target="_blank" class="w-full sm:w-auto justify-center bg-white/5 border border-white/10 sm:bg-transparent sm:border-transparent rounded-lg sm:rounded-none group/btn flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-gray-300 hover:text-[#00ff66] transition-all duration-300 relative py-3 sm:py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover/btn:scale-110 text-[#00ff66]/70 group-hover/btn:text-[#00ff66]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Mi Analítico
                            <span class="hidden sm:block absolute bottom-0 left-0 w-0 h-[1px] bg-[#00ff66] shadow-[0_0_10px_#00ff66] transition-all duration-300 group-hover/btn:w-full"></span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-10">
                    <div>
                        <h3 class="text-[#00ff66] text-[10px] font-black uppercase tracking-[0.3em] pb-2 sm:pb-3 mb-3 sm:mb-4 flex items-center gap-2">
                            Asistencias
                        </h3>
                        <div class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar pr-2 sm:pr-3">
                            @forelse($enrollment->training->courseClasses as $class)
                                @php
                                    $att = $enrollment->attendances->where('course_class_id', $class->id)->first();
                                    $isToday = \Carbon\Carbon::parse($class->date)->isToday();
                                @endphp
                                <div class="flex justify-between items-center p-2 sm:p-3 rounded-lg transition-colors {{ $isToday ? 'bg-[#00f5ff]/5 border border-[#00f5ff]/20' : 'bg-white/[0.02]' }}">
                                    <div class="pr-2">
                                        <p class="text-white text-[10px] sm:text-xs font-bold truncate max-w-[120px] sm:max-w-[180px]">{{ $class->name }}</p>
                                        <p class="text-[8px] sm:text-[9px] text-gray-600 font-mono tracking-wider">{{ \Carbon\Carbon::parse($class->date)->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        @if($att)
                                            <span class="text-[7px] sm:text-[8px] font-black uppercase tracking-[0.2em] text-[#00ff66] bg-[#00ff66]/5 px-2 py-1 rounded border border-[#00ff66]/20">Presente</span>
                                        @else
                                            <button wire:click="generateQR({{ $class->id }}, '{{ addslashes($class->name) }}')" class="btn btn-xs sm:btn-sm bg-[#00f5ff]/10 border border-[#00f5ff]/30 text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black rounded text-[8px] sm:text-[9px] font-black uppercase tracking-wider flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                                QR
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-[10px] text-gray-600 italic tracking-wide">Agenda vacía.</p>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h3 class="text-[#0055ff] text-[10px] font-black uppercase tracking-[0.3em] pb-2 sm:pb-3 mb-3 sm:mb-4 flex items-center gap-2">
                            Evaluaciones
                        </h3>
                        <div class="space-y-2">
                            @forelse($enrollment->training->evaluations as $eval)
                                @php
                                    $grade = $enrollment->grades->where('evaluation_id', $eval->id)->first();
                                @endphp
                                <div class="flex justify-between items-center p-2 sm:p-3 rounded-lg bg-white/[0.02]">
                                    <div class="pr-2">
                                        <p class="text-white text-[10px] sm:text-xs font-bold truncate max-w-[120px] sm:max-w-[180px]">{{ $eval->name }}</p>
                                        <p class="text-[8px] sm:text-[9px] text-gray-600 font-mono tracking-wider">Máx: {{ $eval->max_score }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        @if($grade)
                                            <span class="text-lg sm:text-xl font-black {{ $grade->score >= ($eval->max_score * 0.6) ? 'text-[#00ff66]' : 'text-[#ff0055]' }}">{{ $grade->score }}</span>
                                        @else
                                            <span class="text-[7px] sm:text-[8px] font-black uppercase tracking-[0.2em] text-gray-500 bg-black/50 border border-white/5 px-2 py-1 rounded">A evaluar</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-[10px] text-gray-600 italic tracking-wide">Sin evaluaciones.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="space-y-6 sm:space-y-8">
        <div class="bg-[#050814] border border-[#0a192f] rounded-3xl p-5 sm:p-7 relative overflow-hidden shadow-2xl flex flex-col h-[450px] lg:h-[calc(100vh-140px)] lg:min-h-[550px]">
            <h3 class="text-[10px] sm:text-xs font-black text-white uppercase tracking-[0.2em] sm:tracking-[0.3em] mb-4 sm:mb-5 pb-2 sm:pb-3 border-b border-white/5">Tutor IA</h3>

            <div class="flex-1 overflow-y-auto pr-2 sm:pr-3 space-y-3 sm:space-y-4 mb-4 sm:mb-5 custom-scrollbar">
                @foreach($chatHistory as $chat)
                    <div class="flex {{ $chat['sender'] == 'ai' ? 'justify-start' : 'justify-end' }}">
                        <div class="bg-white/[0.03] border {{ $chat['sender'] == 'ai' ? 'border-white/5' : 'border-[#0055ff]/20' }} rounded-2xl p-3 sm:p-4 max-w-[90%] sm:max-w-[85%]">
                            <p class="text-[10px] sm:text-xs leading-relaxed {{ $chat['sender'] == 'ai' ? 'text-gray-300' : 'text-[#00f5ff]' }}">{{ $chat['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <form wire:submit.prevent="askAI" class="mt-auto relative">
                <input type="text" wire:model="aiQuery" class="w-full bg-black/60 border border-white/5 rounded-full py-3 sm:py-3.5 pl-4 sm:pl-6 pr-12 sm:pr-14 text-xs sm:text-sm text-white placeholder-gray-700 focus:outline-none focus:border-[#0055ff]/50 shadow-inner" placeholder="Consulta a la IA...">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-[#0055ff] p-2 hover:text-[#00f5ff] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 sm:h-5 w-4 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </form>
        </div>
    </div>

    @if($showQr)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/90 backdrop-blur-xl animate-[fade-in_0.3s_ease-out]" wire:click.self="closeQR">
            <div class="bg-[#050814] border border-[#00f5ff]/30 rounded-3xl w-full max-w-sm p-6 sm:p-10 text-center shadow-[0_0_70px_rgba(0,245,255,0.15)] relative overflow-hidden">

                <div class="absolute -top-20 -right-20 w-40 h-40 bg-[#00f5ff]/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-[#ff0055]/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <h3 class="font-black text-xs sm:text-sm text-white uppercase tracking-[0.3em] mb-1">Pase de Abordaje</h3>
                    <p class="text-[#00f5ff] text-[9px] sm:text-[10px] font-black uppercase tracking-[0.1em] mb-6 sm:mb-9 drop-shadow-[0_0_8px_rgba(0,245,255,0.8)] truncate px-2">{{ $activeCourseName }}</p>

                    <div class="p-3 sm:p-4 bg-white rounded-2xl inline-block mx-auto mb-6 sm:mb-10 relative group shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $qrToken }}&color=050814&bgcolor=ffffff" alt="QR" class="w-32 h-32 sm:w-44 sm:h-44 rounded-lg object-contain">
                    </div>

                    <button wire:click="closeQR" class="w-full btn btn-outline border-[#ff0055]/50 text-[#ff0055] hover:bg-[#ff0055] hover:text-white rounded-full flex items-center justify-center gap-2 text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em] transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        Destruir Pase QR
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
