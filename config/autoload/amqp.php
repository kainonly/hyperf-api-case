<?php
declare(strict_types=1);

use Simplify\AMQP\AMQPClient;

$ssl = (bool)env('AMQP_SSL', false);
$sslContext = !$ssl ? null : AMQPClient::SSLContext([
    'cafile' => '',
    'verify_peer' => false
]);
$sslProtocol = !$ssl ? null : 'ssl';

return [
    'clients' => [
        'default'
    ],
    'default' => [
        'host' => env('AMQP_HOST', 'localhost'),
        'port' => (int)env('AMQP_PORT', 5672),
        'user' => env('AMQP_USER', 'guest'),
        'password' => env('AMQP_PASS', 'guest'),
        'vhost' => env('AMQP_VHOST', '/'),
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
            'context' => $sslContext,
            'keepalive' => false,
            'heartbeat' => 0,
            'channel_rpc_timeout' => 0.0,
            'ssl_protocol' => $sslProtocol
        ],
    ],
];