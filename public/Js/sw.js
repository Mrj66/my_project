self.addEventListener('install', function(event) {
    event.waitUntil(
    caches.open('v1').then(function(cache) {
        return cache.addAll([
        '/',
        '/public/styles/assistance.css',
        '/public/styles/certificat.css',
        '/public/styles/commerciale.css',
        '/public/styles/login.css',
        '/public/styles/compte.css',
        '/public/styles/menu.css',
        '/public/styles/rapport.css',

        '/assets/app.js'
      ]);
    })
  );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request);
        })
    );
});