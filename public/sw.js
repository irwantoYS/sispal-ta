const CACHE_NAME = "sispal-ta-cache-v1";
const OFFLINE_URL = "/offline"; // Rute ke halaman offline Anda

// Daftar aset inti yang akan di-cache (App Shell)
// Sesuaikan path ini dengan struktur proyek Anda dan aset yang digunakan di welcome.blade.php
const APP_SHELL_URLS = [
    "/", // Halaman utama
    OFFLINE_URL,

    // CSS - Dari welcome.blade.php
    "/bootstrap-5.0.2-dist/css/bootstrap.min.css",
    // Mengomentari CDN untuk caching yang lebih andal, pertimbangkan untuk melokalkannya jika mungkin
    // 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css',
    "/lib/animate/animate.min.css",
    "/lib/owlcarousel/assets/owl.carousel.min.css",
    "/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css",
    // 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css',
    // 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css',
    "/css/style.css",
    "/css/global.css",

    // Gambar Utama (Contoh, tambahkan yang relevan)
    "/storage/images/pgncom-logo.png", // Logo di header
    "/storage/images/Carousel-1.png",
    "/storage/images/Carousel-2.webp",
    "/storage/images/About Us.png",
    "/logo.png", // Untuk apple-touch-icon dari welcome.blade.php, pastikan ada di public/logo.png

    // JavaScript - Dari welcome.blade.php
    "/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js",
    // 'https://code.jquery.com/jquery-3.4.1.min.js',
    // 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js',
    "/lib/owlcarousel/owl.carousel.min.js",
    "/lib/tempusdominus/js/moment.min.js",
    "/lib/tempusdominus/js/moment-timezone.min.js",
    "/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js",
    // 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js',
    "/lib/wow/wow.min.js",
    "/js/main.js",
];

// Event 'install': Caching App Shell
self.addEventListener("install", (event) => {
    console.log("[SW] Event: install");
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => {
                console.log(
                    `[SW] Caching App Shell: ${APP_SHELL_URLS.length} files`
                );
                return cache.addAll(APP_SHELL_URLS);
            })
            .then(() => {
                console.log("[SW] App Shell cached successfully");
                return self.skipWaiting(); // Aktifkan Service Worker baru segera
            })
            .catch((error) => {
                console.error("[SW] App Shell caching failed:", error);
            })
    );
});

// Event 'activate': Membersihkan cache lama
self.addEventListener("activate", (event) => {
    console.log("[SW] Event: activate");
    event.waitUntil(
        caches
            .keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        if (cacheName !== CACHE_NAME) {
                            console.log(
                                `[SW] Deleting old cache: ${cacheName}`
                            );
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
            .then(() => {
                console.log("[SW] Old caches deleted, claiming clients.");
                return self.clients.claim(); // Service Worker mengklaim kontrol atas klien (tab) yang terbuka
            })
    );
});

// Event 'fetch': Menyajikan aset dari cache atau jaringan, dengan fallback ke halaman offline
self.addEventListener("fetch", (event) => {
    const { request } = event;
    // console.log(`[SW] Fetching: ${request.url}`)

    // Hanya tangani request GET
    if (request.method !== "GET") {
        // console.log(`[SW] Ignoring non-GET request: ${request.method} ${request.url}`);
        return;
    }

    // Strategi untuk navigasi HTML (halaman)
    if (request.mode === "navigate") {
        // console.log(`[SW] Handling navigation request: ${request.url}`);
        event.respondWith(
            caches.open(CACHE_NAME).then((cache) => {
                // Coba ambil dari jaringan dulu (Network First for navigation)
                return fetch(request)
                    .then((networkResponse) => {
                        // Jika berhasil, update cache dan sajikan dari jaringan
                        if (networkResponse && networkResponse.ok) {
                            // console.log(`[SW] Navigation success (network): ${request.url}`);
                            cache.put(request, networkResponse.clone());
                        }
                        return networkResponse;
                    })
                    .catch(() => {
                        // Jika jaringan gagal, coba ambil dari cache
                        // console.log(`[SW] Navigation failed (network), trying cache: ${request.url}`);
                        return cache.match(request).then((cachedResponse) => {
                            if (cachedResponse) {
                                // console.log(`[SW] Navigation success (cache): ${request.url}`);
                                return cachedResponse;
                            }
                            // Jika tidak ada di cache juga, fallback ke halaman offline global
                            // console.log(`[SW] Navigation failed (cache), serving offline page for: ${request.url}`);
                            return cache.match(OFFLINE_URL);
                        });
                    });
            })
        );
    }
    // Strategi untuk aset statis lainnya (CSS, JS, Gambar, dll.) - Cache First
    else if (
        APP_SHELL_URLS.some((url) =>
            request.url.endsWith(url.substring(url.lastIndexOf("/")))
        ) ||
        ["style", "script", "image", "font"].includes(request.destination)
    ) {
        // console.log(`[SW] Handling asset request: ${request.url}`);
        event.respondWith(
            caches.open(CACHE_NAME).then((cache) => {
                return cache.match(request).then((cachedResponse) => {
                    if (cachedResponse) {
                        // console.log(`[SW] Asset success (cache): ${request.url}`);
                        return cachedResponse; // Sajikan dari cache jika ada
                    }
                    // Jika tidak ada di cache, ambil dari jaringan dan cache untuk nanti
                    // console.log(`[SW] Asset failed (cache), trying network: ${request.url}`);
                    return fetch(request).then((networkResponse) => {
                        if (networkResponse && networkResponse.ok) {
                            // console.log(`[SW] Asset success (network), caching: ${request.url}`);
                            cache.put(request, networkResponse.clone());
                        }
                        return networkResponse;
                    });
                });
            })
        );
    }
    // Untuk request lainnya (misalnya API calls, atau aset yang tidak masuk kriteria di atas)
    // Biarkan browser menanganinya secara default (network only)
    // else {
    //     console.log(`[SW] Letting browser handle request: ${request.url}`);
    // }
});

console.log("[SW] Service Worker Loaded");
