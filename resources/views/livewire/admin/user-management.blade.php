<div>
    @if (session()->has('message'))
        <div class="alert bg-[#00ff66]/10 border border-[#00ff66]/30 text-[#00ff66] shadow-[0_0_15px_rgba(0,255,102,0.1)] mb-6 rounded-xl backdrop-blur-md animate-[fade-in_0.3s_ease-out]">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="font-bold tracking-wide text-sm sm:text-base">{{ session('message') }}</span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 bg-[#050814] border border-[#0a192f] p-5 sm:p-6 rounded-2xl shadow-2xl gap-4">
        <div class="w-full sm:w-auto text-center sm:text-left">
            <h2 class="text-2xl sm:text-3xl font-black text-white mb-1">Directorio de Usuarios</h2>
            <p class="text-xs sm:text-sm text-gray-400">Control de accesos y roles del sistema.</p>
        </div>
        <button wire:click="create()" class="w-full sm:w-auto btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.4)] transition-all rounded-full px-6 flex justify-center items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            Nuevo Agente
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 relative z-10">
        @forelse($users as $user)
            <div class="bg-black/50 border border-white/5 rounded-2xl p-4 sm:p-6 pt-12 sm:pt-12 relative overflow-hidden group hover:border-[#00f5ff]/50 transition-all hover:shadow-[0_0_20px_rgba(0,245,255,0.1)] flex flex-col items-center text-center">

                <div class="absolute top-4 left-4">
                    @if($user->is_active)
                        <span class="w-2.5 h-2.5 rounded-full bg-[#00ff66] shadow-[0_0_8px_#00ff66] inline-block animate-pulse"></span>
                    @else
                        <span class="w-2.5 h-2.5 rounded-full bg-[#ff0055] shadow-[0_0_8px_#ff0055] inline-block"></span>
                    @endif
                </div>

                <div class="absolute top-3 right-3">
                    @if($user->hasRole('super_admin'))
                        <span class="text-[9px] bg-[#ff0055]/10 border border-[#ff0055]/30 text-[#ff0055] px-2 py-1 rounded uppercase font-bold tracking-widest block">S-Admin</span>
                    @elseif($user->hasRole('profesor'))
                        <span class="text-[9px] bg-[#00ff66]/10 border border-[#00ff66]/30 text-[#00ff66] px-2 py-1 rounded uppercase font-bold tracking-widest block">Profesor</span>
                    @else
                        <span class="text-[9px] bg-[#00f5ff]/10 border border-[#00f5ff]/30 text-[#00f5ff] px-2 py-1 rounded uppercase font-bold tracking-widest block">Estudiante</span>
                    @endif
                </div>

                <div class="mt-2 mb-4">
                    <img src="{{ $user->avatar_url }}" alt="Foto" class="w-20 h-20 sm:w-24 sm:h-24 rounded-full border-2 border-white/10 group-hover:border-[#00f5ff] object-cover transition-colors shadow-lg">
                </div>

                <h3 class="text-base sm:text-lg font-black text-white leading-tight w-full truncate px-2">{{ $user->name }}</h3>
                <h3 class="text-base sm:text-lg font-black text-white leading-tight mb-1 w-full truncate px-2">{{ $user->last_name }}</h3>
                <p class="text-[10px] text-gray-500 font-mono mb-2">DNI: {{ $user->dni ?? 'NO REGISTRADO' }}</p>

                <div class="w-full px-2 mb-6">
                     <p class="text-xs text-[#00f5ff] truncate w-full">{{ $user->email }}</p>
                </div>

                <div class="mt-auto flex flex-col sm:flex-row gap-2 w-full pt-4 border-t border-white/5">
                    <button wire:click="edit({{ $user->id }})" class="w-full sm:flex-1 py-2 sm:py-3 text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-[#00f5ff] hover:bg-[#00f5ff]/10 rounded-lg transition-colors border border-transparent hover:border-[#00f5ff]/30">Editar</button>
                    @if(auth()->id() != $user->id)
                        <button wire:click="delete({{ $user->id }})" onclick="return confirm('¿Borrar usuario definitivamente?')" class="w-full sm:flex-1 py-2 sm:py-3 text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-[#ff0055] hover:bg-[#ff0055]/10 rounded-lg transition-colors border border-transparent hover:border-[#ff0055]/30">Borrar</button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full p-8 text-center text-gray-500 italic border border-white/5 rounded-xl bg-black/40">No hay usuarios en la red.</div>
        @endforelse
    </div>

    <div class="mt-8 overflow-x-auto">{{ $users->links() }}</div>

    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-md bg-black/80">
            <div class="bg-[#050814] border border-[#00f5ff]/30 shadow-[0_0_30px_rgba(0,245,255,0.15)] rounded-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden relative">

                <div class="p-4 sm:p-6 border-b border-white/5 flex-shrink-0 flex justify-between items-center">
                    <h3 class="font-black text-xl sm:text-2xl text-white">
                        {{ $user_id ? 'Actualizar Agente' : 'Registrar Nuevo Agente' }}
                    </h3>
                    <button wire:click="closeModal()" class="text-gray-400 hover:text-[#ff0055] md:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-4 sm:p-6 overflow-y-auto flex-1 custom-scrollbar">
                    <form wire:submit.prevent="store" id="userForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Nombres *</span></label>
                                <input type="text" wire:model="name" class="input bg-black/50 border-white/10 text-white focus:outline-none focus:border-[#00f5ff] w-full transition-all" />
                                @error('name') <span class="text-[#ff0055] text-xs mt-2 font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Apellidos</span></label>
                                <input type="text" wire:model="last_name" class="input bg-black/50 border-white/10 text-white focus:outline-none focus:border-[#00f5ff] w-full transition-all" />
                            </div>

                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">DNI</span></label>
                                <input type="text" wire:model="dni" class="input bg-black/50 border-white/10 text-white focus:outline-none focus:border-[#00f5ff] w-full transition-all" />
                                @error('dni') <span class="text-[#ff0055] text-xs mt-2 font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Teléfono</span></label>
                                <input type="text" wire:model="phone" class="input bg-black/50 border-white/10 text-white focus:outline-none focus:border-[#00f5ff] w-full transition-all" />
                            </div>

                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Correo Electrónico *</span></label>
                                <input type="email" wire:model="email" class="input bg-black/50 border-white/10 text-white focus:outline-none focus:border-[#00f5ff] w-full transition-all" />
                                @error('email') <span class="text-[#ff0055] text-xs mt-2 font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Contraseña {{ $user_id ? '(Omitir)' : '*' }}</span>
                                </label>
                                <input type="password" wire:model="password" class="input bg-black/50 border-white/10 text-white focus:outline-none focus:border-[#00f5ff] w-full transition-all" placeholder="******" />
                                @error('password') <span class="text-[#ff0055] text-xs mt-2 font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control w-full md:col-span-2">
                                <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-[10px] uppercase">Rol del Sistema *</span></label>
                                <select wire:model="role" class="select bg-black/50 border-white/10 text-white focus:outline-none focus:border-[#00f5ff] w-full transition-all">
                                    <option value="" class="bg-[#050814]">-- Seleccione un Rol --</option>
                                    @foreach($roles as $r)
                                        <option value="{{ $r->name }}" class="bg-[#050814]">{{ strtoupper(str_replace('_', ' ', $r->name)) }}</option>
                                    @endforeach
                                </select>
                                @error('role') <span class="text-[#ff0055] text-xs mt-2 font-medium">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-control bg-white/5 p-4 rounded-xl border border-white/5 mt-6 sm:mt-8">
                            <label class="cursor-pointer flex items-center justify-between">
                                <div><span class="text-white font-bold block text-sm">Acceso Activo a la Red</span></div>
                                <input type="checkbox" wire:model="is_active" class="toggle bg-[#00ff66] border-[#00ff66] hover:bg-[#00ff66]" />
                            </label>
                        </div>
                    </form>
                </div>

                <div class="p-4 sm:p-6 border-t border-white/5 bg-black/40 flex-shrink-0 flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <button type="button" wire:click="closeModal()" class="w-full sm:w-auto btn btn-outline border-white/10 text-gray-400 hover:bg-white/10 hover:text-white rounded-full px-6">Cancelar</button>
                    <button type="submit" form="userForm" class="w-full sm:w-auto btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.4)] rounded-full px-8">Guardar Agente</button>
                </div>
            </div>
        </div>
    @endif
</div>
