<?php
declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        if ($throwable instanceof ValidationException) {
            $data = json_encode([
                'error' => 1,
                'msg' => $throwable->errors()
            ], JSON_UNESCAPED_UNICODE);
            $this->stopPropagation();
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200)
                ->withBody(new SwooleStream($data));
        }
        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}
