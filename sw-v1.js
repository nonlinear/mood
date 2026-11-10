// mood service worker — v1
// Purpose: make mood installable (the fetch handler is what unlocks the prompt)
// and keep the shell fast. Images are NOT cached: the gallery is 24k+ files and
// caching them would blow the quota and serve stale photos.

const VERSION = 'mood-v1';
const SHELL = [
  '/',
  '/manifest.json',
  '/icons/icon-192.png',
  '/icons/icon-512.png',
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(VERSION)
      .then((cache) => cache.addAll(SHELL))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(
        keys.filter((k) => k !== VERSION).map((k) => caches.delete(k))
      ))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const req = event.request;

  // Only GET. Never touch POST or range requests.
  if (req.method !== 'GET') return;

  const url = new URL(req.url);

  // Same origin only — never proxy anything else.
  if (url.origin !== self.location.origin) return;

  // The API must always hit the network: a cached /api.php?mode=random would
  // freeze the gallery on one shuffle forever.
  if (url.pathname === '/api.php') return;

  // Images: network only. They are the payload, not the shell.
  if (url.pathname.startsWith('/images/')) return;

  // Navigations: network first, fall back to the cached shell when offline.
  if (req.mode === 'navigate') {
    event.respondWith(
      fetch(req)
        .then((res) => {
          const copy = res.clone();
          caches.open(VERSION).then((c) => c.put('/', copy));
          return res;
        })
        .catch(() => caches.match('/'))
    );
    return;
  }

  // Everything else (icons, manifest, fonts): cache first, then network.
  event.respondWith(
    caches.match(req).then((hit) => hit || fetch(req))
  );
});
