<?php
return [
    'default' => [
        'issuer' => 'system',
        'audience' => 'xxx',
        'expires' => 3600,
        'auto_refresh' => 604800
    ],
    'xsrf' => [
        'issuer' => 'system',
        'audience' => 'xsrf',
        'expires' => 900,
        'auto_refresh' => 0
    ]
];
