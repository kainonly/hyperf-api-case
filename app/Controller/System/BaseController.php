<?php
declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\Curd\CurdInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Hash\HashInterface;
use Hyperf\Extra\Token\TokenInterface;
use Hyperf\Extra\Utils\UtilsInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

/**
 * Class BaseController
 * @package App\Controller\System
 * @property array $body
 * @property bool $switch
 */
class BaseController
{
    /**
     * @Inject()
     * @var RequestInterface
     */
    protected RequestInterface $request;
    /**
     * @Inject()
     * @var ResponseInterface
     */
    protected ResponseInterface $response;
    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected ValidatorFactoryInterface $validation;
    /**
     * @Inject()
     * @var CurdInterface
     */
    protected CurdInterface $curd;
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