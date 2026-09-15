<?php

return [

    'paths' => ['api/*', 'admin/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_filter([
        env('FRONTEND_URL', 'http://localhost:5173'),
        env('ADMIN_URL', 'http://localhost:3000'),
    ]),

    // En local/dev, le port choisi par Vite varie selon ce qui est déjà occupé
    // (5173, 5174, 5183...). On autorise donc n'importe quel port sur
    // localhost/127.0.0.1 hors production plutôt que de figer une liste de ports.
    'allowed_origins_patterns' => array_filter([
        env('APP_ENV') === 'production' ? null : '#^https?://(localhost|127\.0\.0\.1):\d+$#',
    ]),

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
