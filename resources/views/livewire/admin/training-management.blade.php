<div>
    @if (session()->has('message'))
        <div class="alert bg-[#00f5ff]/10 border border-[#00f5ff]/30 text-[#00f5ff] shadow-[0_0_15px_rgba(0,245,255,0.1)] mb-6 rounded-xl backdrop-blur-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="font-bold tracking-wide">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-6 relative overflow-hidden shadow-2xl">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 relative z-10">
            <div>
                <h2 class="text-3xl font-black text-white mb-1">Módulos y Cohortes</h2>
                <p class="text-sm text-gray-400">Configuración de materias, asignación docente y agendas de clases.</p>
            </div>
            <button wire:click="create()" class="btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.4)] transition-all mt-4 md:mt-0 gap-2 rounded-full px-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Nuevo Módulo
            </button>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/5 bg-black/50 backdrop-blur-md relative z-10">
            <table class="table w-full text-gray-300">
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
                                <div class="font-bold text-white text-base">{{ $training->name }}</div>
                                <div class="text-[10px] text-[#00f5ff] font-mono opacity-60">ID-{{ $training->id }} | Capacidad: {{ $training->capacity }}</div>
                            </td>
                            <td class="text-gray-400 text-sm">
                                {{ $training->campus->name ?? 'Virtual' }}
                            </td>
                            <td class="text-gray-400 text-sm">
                                {{ $training->teacher->name ?? '--' }} {{ $training->teacher->last_name ?? '' }}
                            </td>
                            <td class="text-center">
                                <div class="inline-flex items-center gap-1 bg-white/5 border border-white/10 px-2 py-1 rounded text-xs text-[#00f5ff] font-mono shadow-[0_0_10px_rgba(0,245,255,0.05)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ $training->courseClasses->count() }} Clases
                                </div>
                            </td>
                            <td class="text-center">
                                @if($training->is_active)
                                    <span class="px-3 py-1 rounded-full border border-[#00ff66]/50 bg-[#00ff66]/10 text-[#00ff66] text-[10px] font-bold tracking-wider shadow-[0_0_10px_rgba(0,255,102,0.1)]">ACTIVO</span>
                                @else
                                    <span class="px-3 py-1 rounded-full border border-gray-500/50 bg-gray-500/10 text-gray-400 text-[10px] font-bold tracking-wider">INACTIVO</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="edit({{ $training->id }})" class="btn btn-circle btn-sm btn-outline border-[#00f5ff]/30 text-[#00f5ff] hover:bg-[#00f5ff] hover:border-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.6)] transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                    <button wire:click="delete({{ $training->id }})" onclick="return confirm('¿Eliminar módulo y todo su cronograma?')" class="btn btn-circle btn-sm btn-outline border-[#ff0055]/30 text-[#ff0055] hover:bg-[#ff0055] hover:border-[#ff0055] hover:text-white hover:shadow-[0_0_15px_rgba(255,0,85,0.6)] transition-all">
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
        <div class="mt-6">{{ $trainings->links() }}</div>
    </div>

    <div class="modal {{ $isOpen ? 'modal-open' : '' }} backdrop-blur-md bg-black/80 transition-all duration-300">
        <div class="modal-box bg-[#050814] border border-[#00f5ff]/30 shadow-[0_0_40px_rgba(0,245,255,0.15)] rounded-2xl max-w-6xl p-0 overflow-hidden">

            <div class="p-6 border-b border-white/5 bg-gradient-to-r from-black to-[#0a192f]">
                <h3 class="font-black text-2xl text-white uppercase tracking-widest">
                    {{ $training_id ? 'Reconfigurar Módulo' : 'Establecer Nuevo Módulo' }}
                </h3>
            </div>

            <form wire:submit.prevent="store" class="p-6 grid grid-cols-1 lg:grid-cols-12 gap-8 max-h-[70vh] overflow-y-auto custom-scrollbar">

                <div class="lg:col-span-7 space-y-4">
                    <h4 class="text-[#00f5ff] font-bold text-xs uppercase tracking-widest border-b border-[#00f5ff]/20 pb-2 mb-4">Información Base</h4>

                    <div class="form-control w-full">
                        <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Nombre del Módulo *</span></label>
                        <input type="text" wire:model="name" class="input bg-black/50 border-white/10 text-white focus:border-[#00f5ff] w-full" placeholder="Ej: Programación Neurolingüística I" />
                        @error('name') <span class="text-[#ff0055] text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Capacidad Máx.</span></label>
                            <input type="number" wire:model="capacity" class="input bg-black/50 border-white/10 text-white focus:border-[#00f5ff] w-full text-center" />
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
                            <div><span class="text-white font-bold block text-sm">Módulo Activo en Sistema</span></div>
                            <input type="checkbox" wire:model="is_active" class="toggle bg-[#00ff66] border-[#00ff66] hover:bg-[#00ff66]" />
                        </label>
                    </div>
                </div>

                <div class="lg:col-span-5 bg-black/30 border border-white/5 rounded-2xl p-5 flex flex-col h-full">
                    <div class="flex justify-between items-center border-b border-[#00ff66]/20 pb-2 mb-4">
                        <h4 class="text-[#00ff66] font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Agenda de Clases
                        </h4>
                        <button type="button" wire:click="addClass" class="text-xs bg-[#00ff66]/10 text-[#00ff66] border border-[#00ff66]/30 px-3 py-1 rounded hover:bg-[#00ff66] hover:text-black transition-colors font-bold flex items-center gap-1">
                            + Agregar Clase
                        </button>
                    </div>

                    @error('scheduled_classes.*.date')
                        <div class="bg-[#ff0055]/10 border border-[#ff0055]/30 text-[#ff0055] p-2 rounded text-xs mb-3 font-bold text-center">
                            Debes asignar una fecha a todas las clases.
                        </div>
                    @enderror

                    <div class="flex-1 space-y-3 overflow-y-auto custom-scrollbar pr-1">
                        @foreach($scheduled_classes as $index => $class)
                            <div class="flex gap-2 items-start bg-[#0a192f]/50 p-2 rounded-lg border border-white/5 group relative">
                                <div class="w-6 h-8 flex items-center justify-center text-[10px] font-mono font-bold text-gray-500">
                                    {{ $index + 1 }}
                                </div>

                                <div class="flex-1 space-y-2">
                                    <input type="text" wire:model="scheduled_classes.{{ $index }}.name" class="w-full bg-black/50 border border-white/10 rounded py-1 px-2 text-xs text-white focus:border-[#00ff66] focus:outline-none" placeholder="Tema o Título" />
                                    <input type="date" wire:model="scheduled_classes.{{ $index }}.date" class="w-full bg-black/50 border border-white/10 rounded py-1 px-2 text-xs text-[#00f5ff] focus:border-[#00ff66] focus:outline-none" />
                                </div>

                                <button type="button" wire:click="removeClass({{ $index }})" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-[#ff0055] hover:bg-[#ff0055]/10 rounded transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        @endforeach

                        @if(empty($scheduled_classes))
                            <p class="text-center text-gray-500 text-xs italic py-4">No hay clases programadas.</p>
                        @endif
                    </div>
                </div>

                <div class="col-span-1 lg:col-span-12 border-t border-white/5 pt-4 flex justify-end gap-3">
                    <button type="button" wire:click="closeModal()" class="btn btn-outline border-white/10 text-gray-400 hover:bg-white/10 hover:text-white rounded-full px-8">Cancelar</button>
                    <button type="submit" class="btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.5)] rounded-full px-8">Guardar Módulo Completo</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,245,255,0.3); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0,245,255,0.5); }
    </style>
</div>
