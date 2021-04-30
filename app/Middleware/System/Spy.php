<?php
declare(strict_types=1);

namespace App\Middleware\System;

use App\Service\QueueService;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Spy implements MiddlewareInterface
{
    private QueueService $queue;

    public function __construct(QueueService $queueService)
    {
        $this->queue = $queueService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->queue->logger([
            'channel' => 'request',
            'values' => [
                'path' => $request->getUri()->getPath(),
                'username' => Context::get('auth')['user'] ?? 'none',
                'body' => $request->getBody()->getContents(),
                'time' => time(),
            ]
        ]);
        return $handler->handle($request);
    }
}