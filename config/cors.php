<?php
return [
    'supportsCredentials' => true,
    'allowedOrigins' => explode(',', env('ALLOWED_ORIGINS')),
    'allowedHeaders' => ['Content-Type', 'X-Requested-With'],
    'allowedMethods' => ['POST'],
    'exposedHeaders' => [],
    'maxAge' => 31536000,
];
