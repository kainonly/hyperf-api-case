<?php
declare(strict_types=1);
return [
    'default' => [
        'issuer' => 'api.kainonly.com',
        'audience' => '*',
        'expires' => 900
    ],
    'system' => [
        'issuer' => 'api.kainonly.com',
        'audience' => 'console.kainonly.com',
        'expires' => 300
    ],
];
