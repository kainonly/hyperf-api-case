<?php
declare(strict_types=1);

namespace App\Service;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class CommonService
{
    /**
     * @Inject()
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * 获取客户端IP
     * @return string
     */
    public function getClinetIp(): string
    {
        return $this->request->getHeader('X-Real-IP')[0];
    }
}