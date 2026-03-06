<div class="flex flex-col h-full w-full">

    <div class="mb-4 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-black text-white uppercase tracking-widest text-[#00f5ff] flex items-center">
                <span class="w-3 h-3 inline-block rounded-full bg-[#ff0055] animate-pulse mr-2 shadow-[0_0_10px_#ff0055]"></span>
                EN DIRECTO: {{ $training->name }}
            </h2>
            <p class="text-sm text-gray-400 font-mono mt-1">Conexión cifrada p2p. Tu cámara y micrófono están siendo redirigidos al servidor.</p>
        </div>

        <a href="{{ url()->previous() }}" wire:navigate class="btn btn-outline border-white/20 text-gray-400 hover:bg-[#ff0055] hover:border-[#ff0055] hover:text-white rounded-full transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Desconectar y Salir
        </a>
    </div>

    <div class="flex-1 w-full bg-[#050814] rounded-2xl overflow-hidden border border-[#00f5ff]/50 shadow-[0_0_40px_rgba(0,245,255,0.2)] relative min-h-[75vh]" wire:ignore>

        <div id="jitsi-container" class="w-full h-full absolute inset-0">
            <div id="jitsi-loader" class="w-full h-full flex flex-col items-center justify-center bg-black/80">
                <span class="loading loading-ring loading-lg text-[#00f5ff]"></span>
                <p class="text-[#00f5ff] font-mono text-xs mt-4 animate-pulse uppercase tracking-widest">Estableciendo enlace satelital...</p>
            </div>
        </div>

    </div>

    @script
    <script>
        let api = null;

        const initJitsi = () => {
            const container = document.querySelector('#jitsi-container');
            if (!container) return;

            // Ocultamos la animación de carga
            const loader = document.querySelector('#jitsi-loader');
            if(loader) loader.style.display = 'none';

            const domain = 'meet.jit.si';
            const options = {
                roomName: $wire.roomName,
                width: '100%',
                height: '100%',
                parentNode: container,
                userInfo: {
                    displayName: $wire.userName
                },
                configOverwrite: {
                    prejoinPageEnabled: false, // Salta la página previa de Jitsi
                    disableDeepLinking: true,  // Evita que pida descargar la app de Jitsi
                    startWithAudioMuted: true, // Entrar muteado por seguridad
                    startWithVideoMuted: false
                },
                interfaceConfigOverwrite: {
                    HIDE_INVITE_MORE_HEADER: true,
                    DISABLE_DOMINANT_SPEAKER_INDICATOR: false,
                    SHOW_JITSI_WATERMARK: false
                }
            };

            // Iniciamos la transmisión
            api = new window.JitsiMeetExternalAPI(domain, options);
        };

        // Inyección dinámica para evitar bloqueos por el modo SPA (wire:navigate)
        if (typeof window.JitsiMeetExternalAPI === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://meet.jit.si/external_api.js';
            script.onload = initJitsi;
            document.head.appendChild(script);
        } else {
            initJitsi();
        }

        // Cuando el usuario sale de la pantalla, destruimos la llamada para liberar la cámara
        document.addEventListener('livewire:navigating', () => {
            if (api) {
                api.dispose();
            }
        }, { once: true });
    </script>
    @endscript
</div>
