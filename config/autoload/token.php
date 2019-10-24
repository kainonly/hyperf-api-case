<?php
return [
    'key' => env('TOKEN_KEY'),
    'options' => [
        'app' => [
            'issuer' => 'app',
            'audience' => 'everyone',
            'expires' => 3600
        ]
    ]
];
