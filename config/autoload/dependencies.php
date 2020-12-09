<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    Hyperf\Curd\CurdInterface::class => Hyperf\Curd\CurdService::class,
    Hyperf\Extra\Cipher\CipherInterface::class => Hyperf\Extra\Cipher\CipherFactory::class,
    Hyperf\Extra\Hash\HashInterface::class => Hyperf\Extra\Hash\HashFactory::class,
    Hyperf\Extra\Token\TokenInterface::class => Hyperf\Extra\Token\TokenFactory::class,
    Hyperf\Extra\Utils\UtilsInterface::class => Hyperf\Extra\Utils\UtilsFactory::class,
    Hyperf\Extra\Cors\CorsInterface::class => Hyperf\Extra\Cors\CorsFactory::class,
    Hyperf\AMQPClient\AMQPInterface::class => Hyperf\AMQPClient\AMQPFactory::class
];
