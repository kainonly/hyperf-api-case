<?php
declare(strict_types=1);
return [
    'default' => [
        'issuer' => 'api.kainonly.com',
        'audience' => '*',
        'expires' => 3600
    ],
    'system' => [
        'issuer' => 'api.kainonly.com',
        'audience' => 'console.kainonly.com',
        'expires' => 3600
    ],
];
