<?php
declare(strict_types=1);

namespace App\Controller;


use Hyperf\HttpServer\Contract\RequestInterface;

class IndexController
{
    public function index(RequestInterface $request)
    {
        return [
            'headers' => $request->getHeaders(),
            'query' => $request->getQueryParams(),
            'body' => $request->getBody()->getContents()
        ];
    }
}
