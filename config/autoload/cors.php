<?php
declare(strict_types=1);
return [
    'allowed_methods' => explode(',', env('CORS_METHODS', '*')),
    'allowed_origins' => explode(',', env('CORS_ORIGINS', '*')),
    'allowed_headers' => explode(',', env('CORS_HEADERS', 'CONTENT-TYPE,X-REQUESTED-WITH')),
    'exposed_headers' => explode(',', env('CORS_EXPOSED_HEADERS', '')),
    'max_age' => (int)env('CORS_MAX_AGE', 0),
    'allowed_credentials' => env('CORS_CREDENTIALS', false),
];