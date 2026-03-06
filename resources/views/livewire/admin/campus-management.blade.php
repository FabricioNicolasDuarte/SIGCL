<div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @if (session()->has('message'))
        <div class="alert bg-[#00ff66]/10 border border-[#00ff66]/30 text-[#00ff66] shadow-[0_0_15px_rgba(0,255,102,0.1)] mb-6 rounded-xl backdrop-blur-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="font-bold tracking-wide">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-[#050814] border border-[#0a192f] rounded-2xl p-6 relative overflow-hidden shadow-2xl">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 relative z-10">
            <div>
                <h2 class="text-3xl font-black text-white mb-1">Red de Sedes y Nodos</h2>
                <p class="text-sm text-gray-400">Administración de campus y geolocalización global.</p>
            </div>
            <button wire:click="create()" class="btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.4)] transition-all mt-4 md:mt-0 gap-2 rounded-full px-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Nueva Sede
            </button>
        </div>

        <div class="overflow-x-auto rounded-xl border border-white/5 bg-black/50 backdrop-blur-md relative z-10">
            <table class="table w-full text-gray-300">
                <thead class="text-gray-500 text-xs tracking-widest uppercase border-b border-white/5 bg-white/5">
                    <tr>
                        <th class="bg-transparent font-semibold">Sede</th>
                        <th class="bg-transparent font-semibold">Ubicación Fija</th>
                        <th class="bg-transparent font-semibold text-center">Coordenadas</th>
                        <th class="bg-transparent font-semibold text-center">Estado</th>
                        <th class="text-right bg-transparent font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($campuses as $campus)
                        <tr class="hover:bg-white/5 transition-colors duration-300 border-none group">
                            <td>
                                <div class="font-bold text-white text-base">{{ $campus->name }}</div>
                                <div class="text-xs text-[#00f5ff] font-mono opacity-50 group-hover:opacity-100 transition-opacity">NODO-{{ $campus->id }}</div>
                            </td>
                            <td class="text-gray-400">
                                {{ $campus->location ?? '--' }}
                            </td>
                            <td class="text-center">
                                @if($campus->latitude && $campus->longitude)
                                    <div class="tooltip tooltip-bottom" data-tip="Lat: {{ $campus->latitude }} | Lng: {{ $campus->longitude }}">
                                        <div class="flex items-center justify-center gap-1 text-[#00f5ff]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            <span class="text-xs font-mono font-bold tracking-widest">SATÉLITE OK</span>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-600 font-mono text-xs">SIN COORDENADAS</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($campus->is_active)
                                    <span class="px-3 py-1 rounded-full border border-[#00ff66]/50 bg-[#00ff66]/10 text-[#00ff66] text-xs font-bold tracking-wider shadow-[0_0_10px_rgba(0,255,102,0.1)]">ACTIVA</span>
                                @else
                                    <span class="px-3 py-1 rounded-full border border-gray-500/50 bg-gray-500/10 text-gray-400 text-xs font-bold tracking-wider">INACTIVA</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <div class="tooltip tooltip-left" data-tip="Modificar Radar">
                                        <button wire:click="edit({{ $campus->id }})" class="btn btn-circle btn-sm btn-outline border-[#00f5ff]/30 text-[#00f5ff] hover:bg-[#00f5ff] hover:border-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.6)] transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                    </div>
                                    <div class="tooltip tooltip-left" data-tip="Eliminar">
                                        <button wire:click="delete({{ $campus->id }})" class="btn btn-circle btn-sm btn-outline border-[#0055ff]/30 text-[#0055ff] hover:bg-[#0055ff] hover:border-[#0055ff] hover:text-white hover:shadow-[0_0_15px_rgba(0,85,255,0.6)] transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500 italic">No hay sedes registradas en la red.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $campuses->links() }}</div>
    </div>

    <div class="modal {{ $isOpen ? 'modal-open' : '' }} backdrop-blur-md bg-black/80 transition-all duration-300">
        <div class="modal-box bg-[#050814] border border-[#00f5ff]/30 shadow-[0_0_30px_rgba(0,245,255,0.15)] rounded-2xl max-w-5xl">
            <h3 class="font-black text-2xl text-white mb-6 border-b border-white/5 pb-4">
                {{ $campus_id ? 'Reconfigurar Nodo' : 'Establecer Nuevo Nodo' }}
            </h3>

            <form wire:submit.prevent="store" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <div class="form-control w-full mb-5">
                        <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-xs">IDENTIFICADOR DE SEDE *</span></label>
                        <input type="text" wire:model="name" class="input bg-black/50 border-white/10 text-white focus:outline-none focus:border-[#00f5ff] focus:ring-1 focus:ring-[#00f5ff] w-full transition-all" />
                        @error('name') <span class="text-[#0055ff] text-xs mt-2 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control w-full mb-5 relative">
                        <label class="label"><span class="label-text text-[#00f5ff] font-bold tracking-wide text-xs">DIRECCIÓN (BÚSQUEDA AUTOMÁTICA)</span></label>
                        <input type="text" id="locationInput" wire:model="location" class="input bg-[#0a192f] border-[#00f5ff]/50 text-white focus:outline-none focus:border-[#00f5ff] focus:ring-1 focus:ring-[#00f5ff] w-full transition-all shadow-[0_0_10px_rgba(0,245,255,0.1)]" placeholder="Ej: Avenida Libertador 123..." autocomplete="off" />

                        <div wire:ignore>
                            <ul id="suggestionsBox" class="absolute z-50 w-full bg-[#050814] border border-[#00f5ff]/30 shadow-[0_0_25px_rgba(0,245,255,0.3)] rounded-xl mt-1 max-h-48 overflow-y-auto hidden divide-y divide-white/5"></ul>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-xs">LATITUD</span></label>
                            <input type="text" wire:model="latitude" class="input bg-black/50 border-white/10 text-gray-500 focus:outline-none text-xs font-mono" readonly placeholder="Automático" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-xs">LONGITUD</span></label>
                            <input type="text" wire:model="longitude" class="input bg-black/50 border-white/10 text-gray-500 focus:outline-none text-xs font-mono" readonly placeholder="Automático" />
                        </div>
                    </div>

                    <div class="form-control bg-white/5 p-4 rounded-xl border border-white/5 mb-8">
                        <label class="cursor-pointer flex items-center justify-between">
                            <div><span class="text-white font-bold block text-sm">NODO ACTIVO EN RED</span></div>
                            <input type="checkbox" wire:model="is_active" class="toggle bg-[#00ff66] border-[#00ff66] hover:bg-[#00ff66]" />
                        </label>
                    </div>
                </div>

                <div>
                    <label class="label"><span class="label-text text-gray-400 font-semibold tracking-wide text-xs mb-2 block">VISTA SATELITAL EN VIVO</span></label>
                    <div wire:ignore class="rounded-2xl border-2 border-[#00f5ff]/30 overflow-hidden shadow-[0_0_20px_rgba(0,245,255,0.15)] relative">
                        <div id="radarMap" class="w-full h-[380px] bg-[#050814]"></div>
                        <div class="absolute inset-0 pointer-events-none bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSJub25lIiAvPgo8cmVjdCB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJyZ2JhKDAsMjQ1LDI1NSwwLjIpIiAvPgo8L3N2Zz4=')] opacity-50 z-[400]"></div>
                    </div>
                </div>

                <div class="md:col-span-2 border-t border-white/5 pt-6 flex justify-end gap-3 mt-2">
                    <button type="button" wire:click="closeModal()" class="btn btn-outline border-white/10 text-gray-400 hover:bg-white/10 hover:border-white/20 hover:text-white rounded-full px-6">Cancelar</button>
                    <button type="submit" class="btn btn-outline border-[#00f5ff] text-[#00f5ff] hover:bg-[#00f5ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,245,255,0.5)] rounded-full px-8">Guardar Coordenadas</button>
                </div>
            </form>
        </div>
    </div>

    @script
    <script>
        let mapInstance;
        let mapMarker;

        // Ícono de Neón Personalizado
        const neonPin = L.divIcon({
            className: 'custom-neon-marker',
            html: `<div class="w-5 h-5 bg-[#00f5ff] rounded-full shadow-[0_0_20px_#00f5ff] border-2 border-white animate-pulse"></div>`,
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        $wire.on('open-map', (event) => {
            const data = event[0];

            // Le damos 250ms a la ventana flotante para que termine su animación de apertura
            // y obligamos al mapa a recalcular su tamaño (esto evita que quede en blanco)
            setTimeout(() => {
                const mapContainer = document.getElementById('radarMap');
                if (!mapContainer) return;

                if (!mapInstance) {
                    mapInstance = L.map('radarMap').setView([data.lat, data.lng], 15);

                    // Capa Satelital Híbrida
                    L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                        attribution: '&copy; Google Maps',
                        maxZoom: 20
                    }).addTo(mapInstance);

                    // Evento Clic Inverso (Clic en mapa -> Obtiene Dirección)
                    mapInstance.on('click', async function(e) {
                        const lat = e.latlng.lat;
                        const lng = e.latlng.lng;

                        actualizarPin(lat, lng);

                        // Enviamos coordenadas a Livewire
                        @this.set('latitude', lat);
                        @this.set('longitude', lng);

                        // API Geocodificación Inversa
                        try {
                            const input = document.getElementById('locationInput');
                            input.placeholder = "Escaneando satélite...";

                            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                            const result = await res.json();

                            if(result && result.display_name) {
                                input.value = result.display_name;
                                @this.set('location', result.display_name);
                            } else {
                                input.placeholder = "Ej: Avenida Libertador 123...";
                            }
                        } catch(err) { console.error("Error al obtener dirección", err); }
                    });
                } else {
                    // Si el mapa ya existía, lo "despertamos" para que llene el espacio
                    mapInstance.invalidateSize();
                    mapInstance.setView([data.lat, data.lng], 15);
                }

                if(data.hasMarker) {
                    actualizarPin(data.lat, data.lng);
                } else if (mapMarker) {
                    mapInstance.removeLayer(mapMarker);
                }
            }, 250);
        });

        function actualizarPin(lat, lng) {
            if(mapMarker) mapInstance.removeLayer(mapMarker);
            mapMarker = L.marker([lat, lng], {icon: neonPin}).addTo(mapInstance);
        }

        // Buscador Predictivo
        let debounceTimer;
        document.addEventListener('input', function(e) {
            if(e.target && e.target.id === 'locationInput') {
                clearTimeout(debounceTimer);
                const query = e.target.value;
                const box = document.getElementById('suggestionsBox');

                if(query.length < 4) {
                    box.classList.add('hidden');
                    return;
                }

                debounceTimer = setTimeout(async () => {
                    try {
                        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
                        const data = await res.json();

                        box.innerHTML = '';
                        if(data.length > 0) {
                            box.classList.remove('hidden');
                            data.forEach(item => {
                                const li = document.createElement('li');
                                li.className = 'p-3 hover:bg-[#00f5ff]/20 text-sm text-gray-300 cursor-pointer transition-colors';
                                li.innerText = item.display_name;
                                li.onclick = function() {
                                    e.target.value = item.display_name;
                                    @this.set('location', item.display_name);
                                    @this.set('latitude', item.lat);
                                    @this.set('longitude', item.lon);

                                    box.classList.add('hidden');

                                    if(mapInstance) {
                                        mapInstance.setView([item.lat, item.lon], 16);
                                        actualizarPin(item.lat, item.lon);
                                    }
                                };
                                box.appendChild(li);
                            });
                        } else {
                            box.classList.add('hidden');
                        }
                    } catch(err) {}
                }, 600);
            }
        });

        document.addEventListener('click', function(e) {
            if(e.target && e.target.id !== 'locationInput') {
                const box = document.getElementById('suggestionsBox');
                if(box) box.classList.add('hidden');
            }
        });
    </script>
    @endscript
</div>
