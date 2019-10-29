<?php
return [
    'supportsCredentials' => true,
    'allowedOrigins' => ['http://localhost:4200'],
    'allowedHeaders' => ['Content-Type', 'X-Requested-With'],
    'allowedMethods' => ['POST'],
    'exposedHeaders' => [],
    'maxAge' => 31536000,
];
