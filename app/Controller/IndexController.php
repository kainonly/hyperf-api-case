<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\Extra\Utils\UtilsInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class IndexController
{
    public function index()
    {
        return ['version' => 1.0];
    }

    public function cookie(UtilsInterface $utils, ResponseInterface $response)
    {
        return $response->withCookie($utils->cookie('test', 'tester', [
            'expire' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'raw' => true,
            'samesite' => 'strict',
        ]));
    }
}
