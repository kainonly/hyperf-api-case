<?php

namespace App\Controller\System;

use Hyperf\Curd\CurdController;
use Hyperf\Extra\Contract\HashServiceInterface;
use Hyperf\Extra\Contract\TokenServiceInterface;
use Hyperf\Extra\Contract\UtilsServiceInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

class Base extends CurdController
{
    /**
     * @var HashServiceInterface
     */
    protected $hash;
    /**
     * @var TokenServiceInterface
     */
    protected $token;
    /**
     * @var UtilsServiceInterface
     */
    protected $utils;

    public function __construct(
        ContainerInterface $container,
        RequestInterface $request,
        ResponseInterface $response,
        ValidatorFactoryInterface $validation,
        HashServiceInterface $hash,
        TokenServiceInterface $token,
        UtilsServiceInterface $utils
    )
    {
        parent::__construct($container, $request, $response, $validation);
        $this->hash = $hash;
        $this->token = $token;
        $this->utils = $utils;
    }
}