<?php
return [
    'key' => env('TOKEN_KEY'),
    'options' => [
        'system' => [
            'issuer' => 'system',
            'audience' => 'everyone',
            'expires' => 3600
        ]
    ]
];
