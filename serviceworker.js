var staticCacheName = "the-shop-pwa-" + new Date().getTime();
var filesToCache = [
    '/public/web-assets/img/icons/icon-72x72.png',
    '/public/web-assets/img/icons/icon-96x96.png',
    '/public/web-assets/img/icons/icon-128x128.png',
    '/public/web-assets/img/icons/icon-144x144.png',
    '/public/web-assets/img/icons/icon-152x152.png',
    '/public/web-assets/img/icons/icon-192x192.png',
    '/public/web-assets/img/icons/icon-384x384.png',
    '/public/web-assets/img/icons/icon-512x512.png',
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("the-shop-pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});
