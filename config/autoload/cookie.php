<?php
declare(strict_types=1);
return [
    'expire' => (int)env('COOKIE_EXPIRE', 0),
    'path' => env('COOKIE_PATH', '/'),
    'domain' => env('COOKIE_DOMAIN', ''),
    'secure' => (bool)env('COOKIE_SECURE', false),
    'httponly' => (bool)env('COOKIE_HTTPONLY', false),
    'raw' => true,
    'samesite' => env('COOKIE_SAMESITE', null),
];
