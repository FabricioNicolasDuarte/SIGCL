<div>
    @if (session()->has('message'))
        <div class="alert bg-[#00f5ff]/10 border border-[#00f5ff]/30 text-[#00f5ff] shadow-[0_0_15px_rgba(0,245,255,0.1)] mb-6 rounded-xl backdrop-blur-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="font-bold tracking-wide text-sm sm:text-base">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-4 sm:p-6 relative overflow-hidden shadow-2xl">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 sm:mb-8 relative z-10">
            <div class="w-full sm:w-auto text-center sm:text-left">
                <h2 class="text-2xl sm:text-3xl font-black text-white mb-1">Módulos y Cohortes</h2>
                <p class="text-xs sm:text-sm text-gray-400">Configuración de materias y agendas de clases.</p>
            </div>
            <button wire:click="create()" class="w-full sm:w-auto btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.4)] transition-all flex justify-center items-center gap-2 rounded-full px-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Nuevo Módulo
            </button>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/5 bg-black/50 backdrop-blur-md relative z-10 custom-scrollbar">
            <table class="table w-full text-gray-300 whitespace-nowrap">
                <thead class="text-gray-500 text-xs tracking-widest uppercase border-b border-white/5 bg-white/5">
                    <tr>
                        <th class="bg-transparent font-semibold">Módulo</th>
                        <th class="bg-transparent font-semibold">Sede / Nodo</th>
                        <th class="bg-transparent font-semibold">Docente</th>
                        <th class="bg-transparent font-semibold text-center">Agenda</th>
                        <th class="bg-transparent font-semibold text-center">Estado</th>
                        <th class="text-right bg-transparent font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($trainings as $training)
                        <tr class="hover:bg-white/5 transition-colors duration-300 border-none group">
                            <td>
                                <div class="font-bold text-white text-sm sm:text-base">{{ $training->name }}</div>
                                <div class="text-[10px] text-[#00f5ff] font-mono opacity-60">ID-{{ $training->id }} | Capacidad: {{ $training->capacity }}</div>
                            </td>
                            <td class="text-gray-400 text-xs sm:text-sm">
                                {{ $training->campus->name ?? 'Virtual' }}
                            </td>
                            <td class="text-gray-400 text-xs sm:text-sm">
                                {{ $training->teacher->name ?? '--' }} {{ $training->teacher->last_name ?? '' }}
                            </td>
                            <td class="text-center">
                                <div class="inline-flex items-center gap-1 bg-white/5 border border-white/10 px-2 py-1 rounded text-[10px] sm:text-xs text-[#00f5ff] font-mono">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ $training->courseClasses->count() }} Clases
                                </div>
                            </td>
                            <td class="text-center">
                                @if($training->is_active)
                                    <span class="px-2 py-1 sm:px-3 rounded-full border border-[#00ff66]/50 bg-[#00ff66]/10 text-[#00ff66] text-[9px] sm:text-[10px] font-bold tracking-wider">ACTIVO</span>
                                @else
                                    <span class="px-2 py-1 sm:px-3 rounded-full border border-gray-500/50 bg-gray-500/10 text-gray-400 text-[9px] sm:text-[10px] font-bold tracking-wider">INACTIVO</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="edit({{ $training->id }})" class="btn btn-circle btn-sm btn-outline border-[#00f5ff]/30 text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                    <button wire:click="delete({{ $training->id }})" onclick="return confirm('¿Eliminar módulo y su cronograma?')" class="btn btn-circle btn-sm btn-outline border-[#ff0055]/30 text-[#ff0055] hover:bg-[#ff0055] hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500 italic">No hay módulos registrados en la red.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 overflow-x-auto">{{ $trainings->links() }}</div>
    </div>

    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4 backdrop-blur-md bg-black/80">
            <div class="bg-[#050814] border border-[#00f5ff]/30 shadow-[0_0_40px_rgba(0,245,255,0.15)] rounded-2xl w-full max-w-6xl max-h-[95vh] flex flex-col overflow-hidden relative">

                <div class="p-4 sm:p-6 border-b border-white/5 bg-gradient-to-r from-black to-[#0a192f] flex justify-between items-center flex-shrink-0">
                    <h3 class="font-black text-lg sm:text-2xl text-white uppercase tracking-widest">
                        {{ $training_id ? 'Reconfigurar Módulo' : 'Establecer Nuevo Módulo' }}
                    </h3>
                    <button wire:click="closeModal()" class="text-gray-400 hover:text-[#ff0055] md:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-4 sm:p-6 overflow-y-auto flex-1 custom-scrollbar">
                    <form id="trainingForm" wire:submit.prevent="store" class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">

                        <div class="lg:col-span-7 space-y-4">
                            <h4 class="text-[#00f5ff] font-bold text-[10px] sm:text-xs uppercase tracking-widest border-b border-[#00f5ff]/20 pb-2 mb-2 sm:mb-4">Información Base</h4>

                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Nombre del Módulo *</span></label>
                                <input type="text" wire:model="name" class="input bg-black/50 border-white/10 text-white focus:border-[#00f5ff] w-full" placeholder="Ej: Programación..." />
                                @error('name') <span class="text-[#ff0055] text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Sede de Dictado *</span></label>
                                    <select wire:model="campus_id" class="select bg-black/50 border-white/10 text-white focus:border-[#00f5ff] w-full">
                                        <option value="">Seleccione Sede</option>
                                        @foreach($campuses as $campus)
                                            <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('campus_id') <span class="text-[#ff0055] text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Docente Asignado *</span></label>
                                    <select wire:model="teacher_id" class="select bg-black/50 border-white/10 text-white focus:border-[#00f5ff] w-full">
                                        <option value="">Seleccione Docente</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }} {{ $teacher->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('teacher_id') <span class="text-[#ff0055] text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Capacidad Máx.</span></label>
                                    <input type="number" wire:model="capacity" class="input bg-black/50 border-white/10 text-white focus:border-[#00f5ff] w-full sm:text-center" />
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Fecha de Inicio</span></label>
                                    <input type="date" wire:model="start_date" class="input bg-black/50 border-white/10 text-gray-300 focus:border-[#00f5ff] w-full text-sm" />
                                </div>
                                <div class="form-control w-full">
                                    <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Fecha de Fin</span></label>
                                    <input type="date" wire:model="end_date" class="input bg-black/50 border-white/10 text-gray-300 focus:border-[#00f5ff] w-full text-sm" />
                                </div>
                            </div>

                            <div class="form-control bg-white/5 p-4 rounded-xl border border-white/5 mt-4">
                                <label class="cursor-pointer flex items-center justify-between">
                                    <div><span class="text-white font-bold block text-xs sm:text-sm">Módulo Activo en Sistema</span></div>
                                    <input type="checkbox" wire:model="is_active" class="toggle toggle-sm sm:toggle-md bg-[#00ff66] border-[#00ff66] hover:bg-[#00ff66]" />
                                </label>
                            </div>
                        </div>

                        <div class="lg:col-span-5 bg-black/30 border border-white/5 rounded-2xl p-4 sm:p-5 flex flex-col h-full min-h-[300px]">
                            <div class="flex justify-between items-center border-b border-[#00ff66]/20 pb-2 mb-4">
                                <h4 class="text-[#00ff66] font-bold text-[10px] sm:text-xs uppercase tracking-widest flex items-center gap-1 sm:gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    Agenda
                                </h4>
                                <button type="button" wire:click="addClass" class="text-[10px] sm:text-xs bg-[#00ff66]/10 text-[#00ff66] border border-[#00ff66]/30 px-2 sm:px-3 py-1 rounded hover:bg-[#00ff66] hover:text-black transition-colors font-bold flex items-center gap-1">
                                    + Añadir
                                </button>
                            </div>

                            @error('scheduled_classes.*.date')
                                <div class="bg-[#ff0055]/10 border border-[#ff0055]/30 text-[#ff0055] p-2 rounded text-[10px] mb-3 font-bold text-center">
                                    Asigna fecha a todas las clases.
                                </div>
                            @enderror

                            <div class="flex-1 space-y-3 overflow-y-auto custom-scrollbar pr-1">
                                @foreach($scheduled_classes as $index => $class)
                                    <div class="flex gap-2 items-start bg-[#0a192f]/50 p-2 rounded-lg border border-white/5 group relative">
                                        <div class="w-4 sm:w-6 h-8 flex items-center justify-center text-[10px] font-mono font-bold text-gray-500">
                                            {{ $index + 1 }}
                                        </div>

                                        <div class="flex-1 space-y-2">
                                            <input type="text" wire:model="scheduled_classes.{{ $index }}.name" class="w-full bg-black/50 border border-white/10 rounded py-1 px-2 text-xs text-white focus:border-[#00ff66] focus:outline-none" placeholder="Tema o Título" />
                                            <input type="date" wire:model="scheduled_classes.{{ $index }}.date" class="w-full bg-black/50 border border-white/10 rounded py-1 px-2 text-[10px] sm:text-xs text-[#00f5ff] focus:border-[#00ff66] focus:outline-none" />
                                        </div>

                                        <button type="button" wire:click="removeClass({{ $index }})" class="w-6 h-8 sm:w-8 flex items-center justify-center text-gray-500 hover:text-[#ff0055] hover:bg-[#ff0055]/10 rounded transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                @endforeach

                                @if(empty($scheduled_classes))
                                    <p class="text-center text-gray-500 text-xs italic py-4">No hay clases programadas.</p>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-4 sm:p-6 border-t border-white/5 bg-black/40 flex-shrink-0 flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <button type="button" wire:click="closeModal()" class="w-full sm:w-auto btn btn-outline border-white/10 text-gray-400 hover:bg-white/10 hover:text-white rounded-full px-8">Cancelar</button>
                    <button type="submit" form="trainingForm" class="w-full sm:w-auto btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black rounded-full px-8">Guardar Módulo</button>
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
