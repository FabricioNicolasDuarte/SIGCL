const CACHE_NAME = 'sigcl-pro-v1';
const urlsToCache = [
    '/',
    '/dashboard',
    '/images/fondo1.png',
    '/images/Recurso1.png'
];

// Instalación del Service Worker
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Caché abierto');
                return cache.addAll(urlsToCache);
            })
    );
});

// Interceptar peticiones para que funcione más rápido
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                if (response) {
                    return response; // Devuelve la versión guardada si existe
                }
                return fetch(event.request);
            })
    );
});
