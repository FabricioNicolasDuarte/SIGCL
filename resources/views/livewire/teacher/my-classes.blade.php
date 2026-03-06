<div>
    <script src="https://unpkg.com/html5-qrcode"></script>

    @if (session()->has('message'))
        <div class="alert bg-[#00ff66]/10 border border-[#00ff66]/30 text-[#00ff66] shadow-[0_0_15px_rgba(0,255,102,0.1)] mb-6 rounded-xl backdrop-blur-md animate-[fade-in_0.3s_ease-out]">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="font-bold tracking-wide">{{ session('message') }}</span>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 bg-[#050814] border border-[#0a192f] p-6 rounded-2xl shadow-2xl">
        <div>
            <h2 class="text-2xl font-black text-white flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#00ff66]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" /></svg>
                Mis Módulos Asignados
            </h2>
            <p class="text-sm text-gray-400 mt-1">Supervisa asistencias y registra evaluaciones parciales.</p>
        </div>

        <button onclick="document.getElementById('scanner_modal').showModal(); startScanner();" class="btn btn-outline border-[#00ff66] text-[#00ff66] hover:bg-[#00ff66] hover:text-black hover:shadow-[0_0_20px_rgba(0,255,102,0.4)] transition-all mt-4 md:mt-0 rounded-full px-8 gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            Lector QR
        </button>
    </div>

    @if($myClasses->isEmpty())
        <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-8 text-center shadow-2xl">
            <h3 class="text-2xl font-black text-white mb-2">Sin clases asignadas</h3>
            <p class="text-gray-400">No tienes cursos asignados para dictar en este momento.</p>
        </div>
    @else
        <div class="space-y-8">
            @foreach($myClasses as $class)
                <div class="bg-[#050814] border border-[#0a192f] rounded-2xl relative overflow-hidden shadow-2xl group border-l-4 border-l-[#00ff66]">
                    <div class="p-6 md:p-8 relative z-10">
                        <div class="flex flex-col xl:flex-row justify-between xl:items-center gap-4 border-b border-white/5 pb-6 mb-6">
                            <div>
                                <h2 class="text-3xl font-black text-white mb-2">{{ $class->name }}</h2>
                                <p class="text-sm text-gray-400 flex items-center gap-4">
                                    <span class="flex items-center gap-1"><span class="text-[#00f5ff]">●</span> Sede: {{ $class->campus->name ?? 'Virtual' }}</span>
                                    <span class="flex items-center gap-1"><span class="text-[#00f5ff]">●</span> Alumnos: {{ $class->enrollments->count() }}</span>
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('virtual.room', $class->id) }}" wire:navigate class="btn bg-black border border-[#00ff66]/50 text-[#00ff66] hover:bg-[#00ff66] hover:text-black font-bold uppercase tracking-widest rounded-full px-6 shadow-[0_0_15px_rgba(0,255,102,0.2)] transition-all flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                    Abrir Sala Virtual
                                </a>

                                <button wire:click="openAnnouncementModal({{ $class->id }})" class="btn bg-[#00f5ff]/10 text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black border border-[#00f5ff]/50 font-bold uppercase tracking-widest rounded-full px-6 shadow-[0_0_15px_rgba(0,245,255,0.2)] transition-all flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                                    Enviar Anuncio
                                </button>

                                <a href="{{ route('reports.matrix', $class->id) }}" target="_blank" class="btn bg-white/10 text-white hover:bg-white hover:text-black border border-white/30 font-bold uppercase tracking-widest rounded-full px-6 transition-all flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#ff0055]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    Acta Oficial
                                </a>
                            </div>
                        </div>

                        @if($class->enrollments->isEmpty())
                            <p class="text-gray-500 italic text-sm p-5 bg-white/5 rounded-xl border border-white/5">Aún no hay alumnos matriculados en este curso.</p>
                        @else

                            <div class="mb-8">
                                <h3 class="text-sm font-bold text-[#00ff66] mb-3 tracking-widest uppercase flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Control de Asistencias (Cohorte)
                                </h3>
                                <div class="overflow-x-auto rounded-xl border border-[#00ff66]/20 bg-black/40 backdrop-blur-md custom-scrollbar">
                                    <table class="table w-full text-gray-300">
                                        <thead class="text-gray-500 text-[10px] tracking-widest uppercase border-b border-white/5 bg-white/5">
                                            <tr>
                                                <th class="bg-transparent font-semibold py-4 pl-4 sticky left-0 z-20 bg-[#050814]">Estudiante</th>
                                                @forelse($class->courseClasses as $courseClass)
                                                    <th class="bg-transparent font-semibold py-4 text-center min-w-[120px] border-l border-white/5">
                                                        <span class="text-[#00ff66] block truncate w-24 mx-auto" title="{{ $courseClass->name }}">{{ $courseClass->name }}</span>
                                                        <span class="text-[9px] opacity-70">{{ \Carbon\Carbon::parse($courseClass->date)->format('d/m') }}</span>
                                                    </th>
                                                @empty
                                                    <th class="bg-transparent font-semibold py-4 text-center italic text-[#ff0055]/70">Agenda no configurada</th>
                                                @endforelse
                                                <th class="bg-transparent font-semibold py-4 text-center border-l border-white/5">Tot</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-white/5">
                                            @foreach($class->enrollments as $enrollment)
                                                <tr class="hover:bg-white/5 transition-colors border-none group">

                                                    <td class="font-bold text-white text-sm whitespace-nowrap sticky left-0 z-10 bg-[#050814] group-hover:bg-[#0a192f] border-r border-white/5">
                                                        <div class="flex items-center gap-3">
                                                            <img src="{{ $enrollment->student->avatar_url }}" alt="Foto" class="w-8 h-8 rounded-full border border-white/10 object-cover">
                                                            <div>
                                                                {{ $enrollment->student->name ?? 'N/A' }} {{ $enrollment->student->last_name ?? '' }}
                                                                <span class="block text-[9px] font-mono text-[#00f5ff] opacity-50 uppercase tracking-widest">DNI: {{ $enrollment->student->dni ?? '--' }}</span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    @foreach($class->courseClasses as $courseClass)
                                                        @php $att = $enrollment->attendances->where('course_class_id', $courseClass->id)->first(); @endphp
                                                        <td class="text-center p-2 border-l border-white/5">
                                                            @if($att)
                                                                <div class="inline-block px-2 py-1 bg-[#00ff66]/10 border border-[#00ff66]/30 rounded text-[#00ff66] text-[9px] font-mono shadow-[0_0_10px_rgba(0,255,102,0.1)]">
                                                                    IN: {{ $att->entry_time ? \Carbon\Carbon::parse($att->entry_time)->format('H:i') : '--:--' }}<br>
                                                                    OUT: {{ $att->exit_time ? \Carbon\Carbon::parse($att->exit_time)->format('H:i') : '--:--' }}
                                                                </div>
                                                            @else
                                                                <span class="text-gray-600 font-bold text-xs">-</span>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    <td class="text-center border-l border-white/5">
                                                        <div class="inline-flex w-7 h-7 rounded-full bg-[#00ff66]/10 text-[#00ff66] text-xs font-bold items-center justify-center">{{ $enrollment->attendances->count() }}</div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div>
                                <div class="flex flex-col md:flex-row md:items-center justify-between mb-3 gap-4">
                                    <h3 class="text-sm font-bold text-[#00f5ff] tracking-widest uppercase flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        Libro de Calificaciones (Notas)
                                    </h3>

                                    <div class="flex gap-2">
                                        <button wire:click="openEvalModal({{ $class->id }})" class="btn btn-sm bg-white/5 border-white/10 text-white hover:bg-white/10 hover:border-white transition-all rounded-lg text-xs">
                                            + Programar Evaluación
                                        </button>
                                        @if($class->evaluations->isNotEmpty())
                                            <button wire:click="saveGrades({{ $class->id }})" class="btn btn-sm bg-[#00f5ff]/10 border-[#00f5ff]/50 text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black shadow-[0_0_15px_rgba(0,245,255,0.3)] transition-all rounded-lg text-xs">
                                                Guardar Notas
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <div class="overflow-x-auto rounded-xl border border-[#00f5ff]/20 bg-black/40 backdrop-blur-md custom-scrollbar">
                                    <table class="table w-full text-gray-300">
                                        <thead class="text-gray-500 text-[10px] tracking-widest uppercase border-b border-white/5 bg-white/5">
                                            <tr>
                                                <th class="bg-transparent font-semibold py-4 pl-4 sticky left-0 z-20 bg-[#050814]">Estudiante</th>
                                                @forelse($class->evaluations as $eval)
                                                    <th class="bg-transparent font-semibold py-4 text-center min-w-[120px] border-l border-white/5 group/th relative">
                                                        <div class="text-[#00f5ff]">{{ $eval->name }}</div>
                                                        <div class="text-[9px] opacity-70">{{ \Carbon\Carbon::parse($eval->date)->format('d/m/Y') }} | Max: {{ $eval->max_score }}</div>

                                                        <button wire:click="deleteEvaluation({{ $eval->id }})" onclick="return confirm('¿Eliminar evaluación y todas sus notas?')" class="absolute top-2 right-2 text-gray-600 hover:text-[#ff0055] opacity-0 group-hover/th:opacity-100 transition-opacity">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                        </button>
                                                    </th>
                                                @empty
                                                    <th class="bg-transparent font-semibold py-4 text-center italic text-[#ff0055]/70">No has programado exámenes ni TPs.</th>
                                                @endforelse
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-white/5">
                                            @foreach($class->enrollments as $enrollment)
                                                <tr class="hover:bg-white/5 transition-colors border-none group">

                                                    <td class="font-bold text-white text-sm whitespace-nowrap sticky left-0 z-10 bg-[#050814] group-hover:bg-[#0a192f] border-r border-white/5">
                                                        <div class="flex items-center gap-3">
                                                            <img src="{{ $enrollment->student->avatar_url }}" alt="Foto" class="w-8 h-8 rounded-full border border-white/10 object-cover">
                                                            <div>
                                                                {{ $enrollment->student->name ?? 'N/A' }} {{ $enrollment->student->last_name ?? '' }}
                                                            </div>
                                                        </div>
                                                    </td>

                                                    @foreach($class->evaluations as $eval)
                                                        <td class="text-center p-2 border-l border-white/5">
                                                            <input type="number" step="0.1" max="{{ $eval->max_score }}"
                                                                wire:model="gradesData.{{ $enrollment->id }}.{{ $eval->id }}"
                                                                class="w-20 bg-[#050814] border border-white/20 rounded py-1 text-center text-white font-mono text-sm focus:border-[#00f5ff] focus:ring-1 focus:ring-[#00f5ff] transition-all">
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="modal {{ $isEvalModalOpen ? 'modal-open' : '' }} backdrop-blur-md bg-black/80 transition-all duration-300">
        <div class="modal-box bg-[#050814] border border-[#00f5ff]/50 shadow-[0_0_40px_rgba(0,245,255,0.2)] rounded-2xl max-w-md">
            <h3 class="font-black text-xl text-white mb-6 uppercase tracking-widest border-b border-white/10 pb-4">Programar Evaluación</h3>
            <form wire:submit.prevent="addEvaluation" class="space-y-4">
                <div>
                    <label class="text-[10px] uppercase text-gray-400 tracking-widest font-bold">Título (Ej: Parcial 1, TP Final)</label>
                    <input type="text" wire:model="newEvalName" class="w-full bg-black/50 border border-white/20 rounded-lg p-3 text-white focus:border-[#00f5ff] mt-1" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] uppercase text-gray-400 tracking-widest font-bold">Fecha Planificada</label>
                        <input type="date" wire:model="newEvalDate" class="w-full bg-black/50 border border-white/20 rounded-lg p-3 text-[#00f5ff] focus:border-[#00f5ff] mt-1" required>
                    </div>
                    <div>
                        <label class="text-[10px] uppercase text-gray-400 tracking-widest font-bold">Nota Máxima</label>
                        <input type="number" wire:model="newEvalMaxScore" class="w-full bg-black/50 border border-white/20 rounded-lg p-3 text-white text-center focus:border-[#00f5ff] mt-1" required>
                    </div>
                </div>
                <div class="modal-action border-t border-white/10 pt-4 mt-6">
                    <button type="button" wire:click="closeEvalModal" class="btn btn-outline border-gray-600 text-gray-400 hover:bg-gray-800 hover:text-white rounded-full">Cancelar</button>
                    <button type="submit" class="btn bg-[#00f5ff]/10 border border-[#00f5ff]/50 text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black rounded-full px-6 shadow-[0_0_15px_rgba(0,245,255,0.3)]">Programar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal {{ $isAnnouncementModalOpen ? 'modal-open' : '' }} backdrop-blur-md bg-black/80 transition-all duration-300">
        <div class="modal-box bg-[#050814] border border-[#00f5ff]/50 shadow-[0_0_40px_rgba(0,245,255,0.2)] rounded-2xl max-w-lg">
            <h3 class="font-black text-xl text-white mb-2 uppercase tracking-widest flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#00f5ff]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                Megáfono de Anuncios
            </h3>
            <p class="text-xs text-gray-400 mb-6 border-b border-white/10 pb-4">Escribe un mensaje. Se enviará una alerta push directamente a la campanita de notificaciones de todos los alumnos inscritos en este módulo.</p>

            <form wire:submit.prevent="sendAnnouncement" class="space-y-4">
                <div>
                    <label class="text-[10px] uppercase text-[#00f5ff] tracking-widest font-bold">Cuerpo del Mensaje</label>
                    <textarea wire:model="announcementMessage" class="w-full bg-black/50 border border-white/20 rounded-lg p-4 text-white focus:border-[#00f5ff] mt-2 h-32 resize-none" placeholder="Ej: Chicos, el parcial de mañana es a libro abierto..." required></textarea>
                </div>

                <div class="modal-action border-t border-white/10 pt-4 mt-6">
                    <button type="button" wire:click="closeAnnouncementModal" class="btn btn-outline border-gray-600 text-gray-400 hover:bg-gray-800 hover:text-white rounded-full">Cancelar</button>
                    <button type="submit" class="btn bg-[#00f5ff]/10 border border-[#00f5ff]/50 text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black rounded-full px-6 shadow-[0_0_15px_rgba(0,245,255,0.3)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        Transmitir a la Red
                    </button>
                </div>
            </form>
        </div>
    </div>

    <dialog id="scanner_modal" class="modal backdrop-blur-md bg-black/80" wire:ignore.self>
        <div class="modal-box bg-[#050814] border border-[#00ff66]/50 shadow-[0_0_40px_rgba(0,255,102,0.2)] rounded-2xl max-w-lg text-center p-8">
            <h3 class="font-black text-2xl text-white mb-2 uppercase tracking-widest">Escáner Biométrico</h3>

            <div class="flex justify-center gap-6 mb-6 mt-4 p-3 bg-white/5 rounded-xl border border-white/10">
                <label class="cursor-pointer flex items-center gap-2 group">
                    <input type="radio" wire:model.live="scanMode" value="entry" class="radio radio-success border-[#00ff66] checked:bg-[#00ff66]" />
                    <span class="text-[#00ff66] font-bold text-xs tracking-widest uppercase group-hover:text-white transition-colors">Modo Entrada</span>
                </label>
                <label class="cursor-pointer flex items-center gap-2 group">
                    <input type="radio" wire:model.live="scanMode" value="exit" class="radio radio-error border-[#ff0055] checked:bg-[#ff0055]" />
                    <span class="text-[#ff0055] font-bold text-xs tracking-widest uppercase group-hover:text-white transition-colors">Modo Salida</span>
                </label>
            </div>

            <p class="text-gray-400 text-[10px] font-mono mb-4 animate-pulse">ESPERANDO CÓDIGO DE ABORDAJE MATRICULADO...</p>

            <div wire:ignore>
                <div id="qr-reader" class="w-full bg-black rounded-xl overflow-hidden border-2 border-[#0a192f] mb-6 min-h-[300px] flex items-center justify-center relative"></div>
            </div>

            @if($scanResult)
                <div class="p-4 rounded-xl border {{ $scanStatus == 'success' ? 'bg-[#00ff66]/10 border-[#00ff66]/50 text-[#00ff66]' : 'bg-[#ff0055]/10 border-[#ff0055]/50 text-[#ff0055]' }} mb-6 animate-[fade-in_0.3s_ease-out]">
                    <p class="font-bold text-sm">{{ $scanResult }}</p>
                </div>
                <button wire:click="resetScanner" onclick="startScanner()" class="btn btn-sm btn-outline border-white/20 text-white rounded-full px-6 hover:bg-white/10 mb-2">Escanear siguiente</button>
            @endif

            <div class="modal-action justify-center mt-0">
                <button type="button" onclick="stopScanner(); document.getElementById('scanner_modal').close();" wire:click="resetScanner" class="btn btn-outline border-gray-600 text-gray-400 hover:bg-gray-800 hover:border-white hover:text-white rounded-full px-8">
                    Cerrar Sistema
                </button>
            </div>
        </div>
    </dialog>

    @script
    <script>
        let html5QrcodeScanner;

        window.startScanner = function() {
            if (@this.get('scanResult')) return;
            const qrContainer = document.getElementById('qr-reader');
            qrContainer.innerHTML = '';
            html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: {width: 250, height: 250}, aspectRatio: 1.0 }, false);
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        window.stopScanner = function() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().catch(error => { console.error("Fallo al detener.", error); });
            }
            @this.resetScanner();
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (html5QrcodeScanner) html5QrcodeScanner.clear();
            @this.processQR(decodedText);
        }

        function onScanFailure(error) {}
    </script>
    @endscript

    <style>
        #qr-reader { border: none !important; }
        #qr-reader img { display: none !important; }
        #qr-reader__dashboard_section_csr span { color: #fff !important; font-family: 'Outfit', sans-serif; }
        #qr-reader__dashboard_section_swaplink { color: #00ff66 !important; text-decoration: none; font-weight: bold; margin-top: 10px; display: inline-block;}
        #qr-reader button { background: transparent; border: 1px solid #00f5ff; color: #00f5ff; padding: 5px 15px; border-radius: 20px; cursor: pointer; margin: 10px 5px; transition: 0.3s; }
        #qr-reader button:hover { background: #00f5ff; color: #000; box-shadow: 0 0 10px rgba(0,245,255,0.4); }

        .custom-scrollbar::-webkit-scrollbar { height: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,245,255,0.3); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0,245,255,0.5); }
    </style>
</div>
