const CACHE_NAME = 'cinewatch-premium-v1';
const ASSETS_TO_CACHE = [
  '/?utm_source=pwa',
  '/manifest.json',
  'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap',
  'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200'
];

// Install Event
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      console.log('PWA: Caching Shell Assets');
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
  self.skipWaiting();
});

// Activate Event
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(keys
        .filter(key => key !== CACHE_NAME)
        .map(key => caches.delete(key))
      );
    })
  );
});

// Fetch Event (Network First for routes, Cache First for assets)
self.addEventListener('fetch', event => {
  const url = new URL(event.request.url);
  
  // Skip caching for external APIs like Midtrans or Groq
  if (url.origin.includes('midtrans') || url.origin.includes('groq')) {
    return;
  }

  event.respondWith(
    caches.match(event.request).then(cacheRes => {
      return cacheRes || fetch(event.request).then(fetchRes => {
        // Cache new assets on the fly
        if (event.request.method === 'GET' && (url.pathname.includes('/storage') || url.pathname.includes('/img'))) {
            return caches.open(CACHE_NAME).then(cache => {
                cache.put(event.request.url, fetchRes.clone());
                return fetchRes;
            });
        }
        return fetchRes;
      });
    }).catch(() => {
        if (event.request.url.indexOf('.html') > -1) {
            return caches.match('/'); // Fallback to home if offline
        }
    })
  );
});

// Notification Listener
self.addEventListener('push', event => {
  const data = event.data.json();
  const options = {
    body: data.body,
    icon: '/pwa-icon.png',
    badge: '/pwa-icon.png',
    vibrate: [100, 50, 100],
    data: { url: data.url }
  };
  event.waitUntil(
    self.registration.showNotification(data.title, options)
  );
});

self.addEventListener('notificationclick', event => {
  event.notification.close();
  event.waitUntil(
    clients.openWindow(event.notification.data.url)
  );
});
