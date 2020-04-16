<?php
return [
    'clients' => [
        'default'
    ],
    'default' => [
        'host' => env('AMQP_HOST', 'localhost'),
        'port' => 5672,
        'user' => env('AMQP_USER', 'guest'),
        'password' => env('AMQP_PASSWORD', 'guest'),
        'vhost' => '/',
        'concurrent' => [
            'limit' => 1,
        ],
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 5,
            'connect_timeout' => 3.0,
            'wait_timeout' => 3.0,
            'heartbeat' => 2.0,
        ],
        'params' => [
            'insist' => false,
            'login_method' => 'AMQPLAIN',
            'login_response' => null,
            'locale' => 'en_US',
            'connection_timeout' => 5.0,
            'read_write_timeout' => 5.0,
            'context' => null,
            'keepalive' => false,
            'heartbeat' => 0
        ],
    ],
];