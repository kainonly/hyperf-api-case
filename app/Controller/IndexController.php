<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpMessage\Cookie\Cookie;
use Hyperf\HttpServer\Contract\ResponseInterface;

class IndexController
{
    public function index(ResponseInterface $response)
    {
        return $response->withCookie(new Cookie(
            'name',
            'kain',
            0,
            '/',
            '',
            true,
            true,
            false,
            Cookie::SAMESITE_STRICT
        ))->json([
            'version' => 1.0
        ]);
    }
}
