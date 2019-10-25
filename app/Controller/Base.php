<?php

namespace App\Controller;

use Hyperf\Curd\CurdController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Contract\HashServiceInterface;
use Hyperf\Extra\Contract\TokenServiceInterface;
use Hyperf\Extra\Contract\UtilsServiceInterface;

class Base extends CurdController
{
    /**
     * @Inject()
     * @var HashServiceInterface
     */
    protected $hash;

    /**
     * @Inject()
     * @var TokenServiceInterface
     */
    protected $token;
    /**
     * @Inject()
     * @var UtilsServiceInterface
     */
    protected $utils;
}