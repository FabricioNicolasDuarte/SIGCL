<div class="space-y-6">
    <div class="bg-[#050814] border border-[#0a192f] p-6 rounded-2xl shadow-2xl relative overflow-hidden group border-t-2 border-t-[#00f5ff]">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-[#00f5ff]/5 rounded-full blur-[80px] pointer-events-none"></div>

        <div class="flex flex-col md:flex-row justify-between md:items-start gap-6 relative z-10">
            <div class="flex-1 w-full">
                <h2 class="text-2xl font-black text-white flex items-center gap-3 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#00f5ff]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Gestor Global de Calificaciones
                </h2>

                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Seleccionar Módulo / Curso</label>
                <select wire:model.live="selectedTrainingId" class="w-full max-w-lg bg-[#0a192f] border border-[#00f5ff]/30 rounded-xl py-3 px-4 text-white focus:outline-none focus:border-[#00f5ff] focus:ring-1 focus:ring-[#00f5ff] transition-all shadow-[0_0_15px_rgba(0,245,255,0.1)]">
                    <option value="">-- Elige un curso para configurar o calificar --</option>
                    @foreach($trainings as $t)
                        <option value="{{ $t->id }}">ID: {{ $t->id }} | {{ $t->name }} ({{ $t->campus->name ?? 'Virtual' }})</option>
                    @endforeach
                </select>
            </div>

            @if($selectedTrainingId)
                <div class="flex-1 w-full bg-black/40 p-5 rounded-xl border border-white/5 animate-[fade-in_0.3s_ease-out]">
                    <h3 class="text-xs font-bold text-[#00f5ff] uppercase tracking-widest mb-3">Configurar Nueva Evaluación</h3>
                    <form wire:submit.prevent="addEvaluation" class="flex gap-3 items-end">
                        <div class="flex-1">
                            <label class="block text-[10px] text-gray-400 mb-1 uppercase">Nombre (Ej: Parcial 1)</label>
                            <input type="text" wire:model="newEvalName" class="w-full bg-[#050814] border border-white/10 rounded-lg py-2 px-3 text-sm text-white focus:border-[#00f5ff] transition-all">
                        </div>
                        <div class="w-24">
                            <label class="block text-[10px] text-gray-400 mb-1 uppercase">Nota Máx</label>
                            <input type="number" wire:model="newEvalMaxScore" class="w-full bg-[#050814] border border-white/10 rounded-lg py-2 px-3 text-sm text-center text-white focus:border-[#00f5ff] transition-all">
                        </div>
                        <button type="submit" class="btn btn-sm h-[38px] bg-[#00f5ff]/10 border border-[#00f5ff]/30 text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black">
                            Añadir
                        </button>
                    </form>
                </div>
            @endif
        </div>

        @if (session()->has('message'))
            <div class="mt-4 p-3 rounded-lg bg-[#00ff66]/10 border border-[#00ff66]/30 text-[#00ff66] text-sm animate-[fade-in_0.3s_ease-out] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                {{ session('message') }}
            </div>
        @endif
    </div>

    @if($selectedTrainingId)
        <div class="bg-[#050814] border border-[#0a192f] rounded-2xl relative overflow-hidden shadow-2xl animate-[fade-in_0.4s_ease-out]">
            <div class="p-6 border-b border-white/5 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white uppercase tracking-widest">Planilla de Registro de Notas</h3>
                <button wire:click="saveGrades" class="btn btn-outline border-[#00ff66] text-[#00ff66] hover:bg-[#00ff66] hover:text-black rounded-full px-8 shadow-[0_0_15px_rgba(0,255,102,0.2)]">
                    Guardar Todas las Notas
                </button>
            </div>

            <div class="overflow-x-auto bg-black/50">
                <table class="table w-full text-gray-300">
                    <thead class="text-gray-500 text-[10px] tracking-widest uppercase border-b border-white/5 bg-white/5">
                        <tr>
                            <th class="bg-transparent font-semibold py-4 w-10">N°</th>
                            <th class="bg-transparent font-semibold py-4 min-w-[200px]">Alumno Matriculado</th>

                            @forelse($evaluations as $eval)
                                <th class="bg-transparent font-semibold py-4 text-center min-w-[120px]">
                                    <div class="text-[#00f5ff]">{{ $eval->name }}</div>
                                    <div class="text-[9px] opacity-50 mt-1 flex justify-center items-center gap-2">
                                        Max: {{ $eval->max_score }}
                                        <button wire:click="deleteEvaluation({{ $eval->id }})" class="text-[#ff0055] hover:text-white" onclick="return confirm('¿Borrar esta evaluación y todas sus notas?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </th>
                            @empty
                                <th class="bg-transparent font-semibold py-4 text-center italic text-[#ff0055]/70">Sin evaluaciones configuradas</th>
                            @endforelse
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($enrollments as $index => $enrollment)
                            <tr class="hover:bg-white/5 transition-colors border-none group">
                                <td class="font-mono text-xs opacity-50">{{ $index + 1 }}</td>
                                <td class="font-bold text-white">
                                    {{ $enrollment->student->name ?? 'N/A' }} {{ $enrollment->student->last_name ?? '' }}
                                    <span class="block text-[10px] font-mono text-[#00f5ff] opacity-60">DNI: {{ $enrollment->student->dni ?? '--' }}</span>
                                </td>

                                @foreach($evaluations as $eval)
                                    <td class="text-center p-2">
                                        <input type="number" step="0.1" max="{{ $eval->max_score }}"
                                            wire:model="gradesData.{{ $enrollment->id }}.{{ $eval->id }}"
                                            class="w-20 bg-[#050814] border border-white/20 rounded-md py-1.5 text-center text-white font-mono text-sm focus:border-[#00ff66] focus:ring-1 focus:ring-[#00ff66] transition-all group-hover:bg-[#0a192f]">
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($evaluations) + 2 }}" class="py-12 text-center text-gray-500 italic">No hay alumnos matriculados en este curso.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center p-20 border-2 border-dashed border-white/10 rounded-2xl bg-black/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            <p class="text-gray-400 font-mono text-sm uppercase tracking-widest">Esperando Selección de Módulo</p>
        </div>
    @endif
</div>
