<?php
declare(strict_types=1);
return [
    'default' => [
        'driver' => Hyperf\Nats\Driver\NatsDriver::class,
        'encoder' => Hyperf\Nats\Encoders\JSONEncoder::class,
        'timeout' => 10.0,
        'options' => [
            'host' => env('NATS_HOST', '127.0.0.1'),
            'port' => env('NATS_PORT', 4222),
            'user' => env('NATS_USER'),
            'pass' => env('NATS_PASS'),
            'lang' => 'php',
        ],
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => 60,
        ],
    ],
];