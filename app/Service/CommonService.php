<?php
declare(strict_types=1);

namespace App\Service;

use Hyperf\HttpServer\Contract\RequestInterface;

class CommonService
{
    /**
     * 获取客户端IP
     * @param RequestInterface $request
     * @return string
     */
    public function getClinetIp(RequestInterface $request): string
    {
        return $request->getHeader('X-Real-IP')[0];
    }
}