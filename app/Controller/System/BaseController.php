<?php
declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\Curd\CurdController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Hash\HashInterface;
use Hyperf\Extra\Token\TokenInterface;
use Hyperf\Extra\Utils\UtilsInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

class BaseController extends CurdController
{
    protected array $middleware = [];
    /**
     * @Inject()
     * @var HashInterface
     */
    protected HashInterface $hash;
    /**
     * @Inject()
     * @var TokenInterface
     */
    protected TokenInterface $token;
    /**
     * @Inject()
     * @var UtilsInterface
     */
    protected UtilsInterface $utils;
}