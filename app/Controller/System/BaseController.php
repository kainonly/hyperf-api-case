<?php
declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\Curd\CurdController;
use Hyperf\Extra\Contract\HashInterface;
use Hyperf\Extra\Contract\TokenInterface;
use Hyperf\Extra\Contract\UtilsInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

class BaseController extends CurdController
{
    protected HashInterface $hash;
    protected TokenInterface $token;
    protected UtilsInterface $utils;

    public function __construct(
        ContainerInterface $container,
        RequestInterface $request,
        ResponseInterface $response,
        ValidatorFactoryInterface $validation,
        HashInterface $hash,
        TokenInterface $token,
        UtilsInterface $utils
    )
    {
        parent::__construct($container, $request, $response, $validation);
        $this->hash = $hash;
        $this->token = $token;
        $this->utils = $utils;
    }
}