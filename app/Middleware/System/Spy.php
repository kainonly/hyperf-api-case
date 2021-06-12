<?php
declare(strict_types=1);

namespace App\Middleware\System;

use Hyperf\Nats\Driver\DriverInterface;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Spy implements MiddlewareInterface
{
    private DriverInterface $nats;

    public function __construct(DriverInterface $nats)
    {
        $this->nats = $nats;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->nats->publish('logger.logs', [
            'path' => $request->getUri()->getPath(),
            'username' => Context::get('auth')['user'] ?? 'none',
            'body' => $request->getBody()->getContents(),
            'time' => time(),
        ]);
        return $handler->handle($request);
    }
}