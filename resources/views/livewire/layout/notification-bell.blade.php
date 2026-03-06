<div class="relative ms-4" x-data="{ open: false }">
    <button @click="open = !open" @click.outside="open = false" class="relative p-2 text-gray-400 hover:text-white transition-colors focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[9px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-[#ff0055] rounded-full shadow-[0_0_10px_rgba(255,0,85,0.6)] animate-pulse">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" x-transition.opacity
         class="absolute right-0 mt-2 w-80 bg-[#050814] border border-[#00f5ff]/30 rounded-xl shadow-[0_0_30px_rgba(0,245,255,0.15)] z-50 overflow-hidden"
         style="display: none;">

        <div class="px-4 py-3 border-b border-white/10 flex justify-between items-center bg-gradient-to-r from-black to-[#0a192f]">
            <h3 class="text-xs font-bold text-white uppercase tracking-widest">Notificaciones</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-[9px] text-[#00f5ff] hover:text-white uppercase tracking-widest transition-colors">Limpiar</button>
            @endif
        </div>

        <div class="max-h-80 overflow-y-auto custom-scrollbar">
            @forelse($notifications as $notification)
                <div class="px-4 py-3 border-b border-white/5 hover:bg-white/5 transition-colors group cursor-pointer" wire:click="markAsRead('{{ $notification->id }}')">
                    <div class="flex items-start gap-3">
                        <div class="mt-1">
                            @if($notification->data['type'] == 'success')
                                <span class="block w-2 h-2 rounded-full bg-[#00ff66] shadow-[0_0_8px_#00ff66]"></span>
                            @elseif($notification->data['type'] == 'warning')
                                <span class="block w-2 h-2 rounded-full bg-[#ff0055] shadow-[0_0_8px_#ff0055]"></span>
                            @else
                                <span class="block w-2 h-2 rounded-full bg-[#00f5ff] shadow-[0_0_8px_#00f5ff]"></span>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-bold text-white">{{ $notification->data['title'] }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 leading-tight">{{ $notification->data['message'] }}</p>
                            <p class="text-[8px] text-gray-600 font-mono mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-6 text-center">
                    <p class="text-xs text-gray-500 italic">No tienes alertas pendientes.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
