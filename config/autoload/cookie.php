<?php
// +----------------------------------------------------------------------
// | Cookie设置
// +----------------------------------------------------------------------
return [
    'expire' => env('COOKIE_EXPIRE', 0),
    'path' => env('COOKIE_PATH', '/'),
    'domain' => env('COOKIE_DOMAIN', ''),
    'secure' => env('COOKIE_SECURE', false),
    'httponly' => env('COOKIE_HTTPONLY', false),
    'setcookie' => false,
    'raw' => false,
    'samesite' => env('COOKIE_SAMESITE', null),
];
