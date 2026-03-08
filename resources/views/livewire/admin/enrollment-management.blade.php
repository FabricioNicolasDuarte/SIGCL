<div>
    @if (session()->has('message'))
        <div class="alert bg-[#00ff66]/10 border border-[#00ff66]/30 text-[#00ff66] shadow-[0_0_15px_rgba(0,255,102,0.1)] mb-6 rounded-xl backdrop-blur-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="font-bold tracking-wide text-sm sm:text-base">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-4 sm:p-6 relative overflow-hidden shadow-2xl">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8 relative z-10">
            <div class="w-full sm:w-auto text-center sm:text-left">
                <h2 class="text-2xl sm:text-3xl font-black text-white mb-1">Registro de Matriculaciones</h2>
                <p class="text-xs sm:text-sm text-gray-400">Asigna estudiantes a cursos y gestiona sus calificaciones.</p>
            </div>
            <button wire:click="create()" class="w-full sm:w-auto btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.4)] transition-all flex justify-center items-center gap-2 rounded-full px-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Matricular Alumno
            </button>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/5 bg-black/50 backdrop-blur-md relative z-10 custom-scrollbar">
            <table class="table w-full text-gray-300 whitespace-nowrap">
                <thead class="text-gray-500 text-xs tracking-widest uppercase border-b border-white/5 bg-white/5">
                    <tr>
                        <th class="bg-transparent font-semibold">Estudiante</th>
                        <th class="bg-transparent font-semibold">Curso Matriculado</th>
                        <th class="bg-transparent font-semibold text-center">Estado</th>
                        <th class="bg-transparent font-semibold text-center">Calificación</th>
                        <th class="text-right bg-transparent font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($enrollments as $enrollment)
                        <tr class="hover:bg-white/5 transition-colors duration-300 border-none group">
                            <td>
                                <div class="font-bold text-white text-sm sm:text-base">{{ $enrollment->student->name ?? '--' }} {{ $enrollment->student->last_name ?? '' }}</div>
                            </td>
                            <td class="text-gray-300 font-medium text-xs sm:text-sm">
                                {{ $enrollment->training->name ?? '--' }}
                            </td>
                            <td class="text-center">
                                @if($enrollment->status == 'enrolled')
                                    <span class="px-2 py-1 sm:px-3 rounded-full border border-[#00f5ff]/50 bg-[#00f5ff]/10 text-[#00f5ff] text-[10px] sm:text-xs font-bold tracking-wider">CURSANDO</span>
                                @elseif($enrollment->status == 'completed')
                                    <span class="px-2 py-1 sm:px-3 rounded-full border border-[#00ff66]/50 bg-[#00ff66]/10 text-[#00ff66] text-[10px] sm:text-xs font-bold tracking-wider">APROBADO</span>
                                @else
                                    <span class="px-2 py-1 sm:px-3 rounded-full border border-gray-500/50 bg-gray-500/10 text-gray-400 text-[10px] sm:text-xs font-bold tracking-wider">ABANDONÓ</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($enrollment->final_grade)
                                    <span class="font-mono text-lg sm:text-xl font-bold {{ $enrollment->final_grade >= 60 ? 'text-[#00ff66]' : 'text-[#0055ff]' }}">{{ $enrollment->final_grade }}</span>
                                    <span class="text-[10px] sm:text-xs text-gray-600">/100</span>
                                @else
                                    <span class="text-gray-600 font-medium tracking-wide">--</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="edit({{ $enrollment->id }})" class="btn btn-circle btn-sm btn-outline border-[#00f5ff]/30 text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </button>
                                    <button wire:click="delete({{ $enrollment->id }})" class="btn btn-circle btn-sm btn-outline border-[#0055ff]/30 text-[#0055ff] hover:bg-[#0055ff] hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-600 italic">No hay estudiantes matriculados en el sistema.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 overflow-x-auto">{{ $enrollments->links() }}</div>
    </div>

    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-md bg-black/80">
            <div class="bg-[#050814] border border-[#00f5ff]/30 shadow-[0_0_30px_rgba(0,245,255,0.15)] rounded-2xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden relative">

                <div class="p-4 sm:p-6 border-b border-white/5 flex-shrink-0 flex justify-between items-center">
                    <h3 class="font-black text-xl sm:text-2xl text-white">
                        {{ $enrollment_id ? 'Gestionar Alumno' : 'Nueva Matriculación' }}
                    </h3>
                    <button wire:click="closeModal()" class="text-gray-400 hover:text-[#ff0055]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-4 sm:p-6 overflow-y-auto flex-1 custom-scrollbar">
                    <form id="enrollForm" wire:submit.prevent="store">
                        <div class="form-control w-full mb-4 sm:mb-5">
                            <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] sm:text-xs">CURSO / CAPACITACIÓN *</span></label>
                            <select wire:model="training_id" class="select bg-black/50 border-white/10 text-white focus:border-[#00f5ff] w-full" {{ $enrollment_id ? 'disabled' : '' }}>
                                <option value="" class="bg-[#050814]">-- Seleccione el Curso --</option>
                                @foreach($trainings as $training)
                                    <option value="{{ $training->id }}" class="bg-[#050814]">{{ $training->name }}</option>
                                @endforeach
                            </select>
                            @error('training_id') <span class="text-[#0055ff] text-xs mt-2 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control w-full mb-4 sm:mb-5">
                            <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] sm:text-xs">ESTUDIANTE *</span></label>
                            <select wire:model="student_id" class="select bg-black/50 border-white/10 text-white focus:border-[#00f5ff] w-full" {{ $enrollment_id ? 'disabled' : '' }}>
                                <option value="" class="bg-[#050814]">-- Seleccione el Estudiante --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" class="bg-[#050814]">{{ $student->name }} {{ $student->last_name }}</option>
                                @endforeach
                            </select>
                            @error('student_id') <span class="text-[#0055ff] text-xs mt-2 font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] sm:text-xs">ESTADO *</span></label>
                                <select wire:model="status" class="select bg-black/50 border-white/10 text-white focus:border-[#00f5ff] w-full">
                                    <option value="enrolled" class="bg-[#050814]">Cursando</option>
                                    <option value="completed" class="bg-[#050814]">Aprobado / Completado</option>
                                    <option value="dropped" class="bg-[#050814]">Abandonó / Reprobó</option>
                                </select>
                                @error('status') <span class="text-[#0055ff] text-xs mt-2 font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] sm:text-xs">NOTA FINAL (0-100)</span></label>
                                <input type="number" wire:model="final_grade" class="input bg-black/50 border-white/10 text-white focus:border-[#00f5ff] w-full font-mono text-lg" min="0" max="100" placeholder="Ej: 85" />
                                @error('final_grade') <span class="text-[#0055ff] text-xs mt-2 font-medium">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-4 sm:p-6 border-t border-white/5 flex-shrink-0 flex flex-col-reverse sm:flex-row justify-end gap-3 bg-black/40">
                    <button type="button" wire:click="closeModal()" class="w-full sm:w-auto btn btn-outline border-white/10 text-gray-400 hover:bg-white/10 hover:text-white rounded-full px-6">Cancelar</button>
                    <button type="submit" form="enrollForm" class="w-full sm:w-auto btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.5)] rounded-full px-8">Guardar</button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,245,255,0.3); border-radius: 10px; }
    </style>
</div>
