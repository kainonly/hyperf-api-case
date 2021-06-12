<?php
declare(strict_types=1);

namespace App\Middleware\System;

use App\Service\LoggerService;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Spy implements MiddlewareInterface
{
    private LoggerService $logger;

    public function __construct(LoggerService $logger)
    {
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->logger->logs([
            'path' => $request->getUri()->getPath(),
            'username' => Context::get('auth')['user'] ?? 'none',
            'body' => $request->getBody()->getContents(),
            'time' => time(),
        ]);
        return $handler->handle($request);
    }
}