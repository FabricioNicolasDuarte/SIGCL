<section class="bg-[#050814] border border-[#00f5ff]/30 p-6 rounded-2xl shadow-[0_0_20px_rgba(0,245,255,0.1)] mb-8 flex flex-col md:flex-row items-center gap-6">
    <div class="relative group">
        <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="h-24 w-24 rounded-full border-2 border-[#00f5ff] object-cover shadow-[0_0_15px_rgba(0,245,255,0.4)]">
        @if ($photo)
            <span class="absolute bottom-0 right-0 bg-[#00ff66] text-black text-[10px] font-bold px-2 py-1 rounded-full border border-black">¡Lista!</span>
        @endif
    </div>

    <form wire:submit.prevent="save" class="flex-1 w-full space-y-4">
        <div>
            <h2 class="text-lg font-bold text-white uppercase tracking-widest">Identidad Visual</h2>
            <p class="text-xs text-gray-400">Actualiza tu foto de perfil. Formatos soportados: JPG, PNG (Máx 2MB).</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3">
            <input type="file" wire:model="photo" accept="image/*" class="file-input file-input-bordered file-input-sm w-full max-w-xs bg-black/50 border-white/20 text-gray-300 focus:border-[#00f5ff]" id="photo-upload">

            <button type="submit" class="btn btn-sm btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black w-full sm:w-auto" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="photo">Subir y Guardar</span>
                <span wire:loading wire:target="photo">Cargando...</span>
            </button>
        </div>
        @error('photo') <span class="text-[#ff0055] text-xs font-bold">{{ $message }}</span> @enderror
        @if (session()->has('message')) <span class="text-[#00ff66] text-xs font-bold">{{ session('message') }}</span> @endif
    </form>
</section>
